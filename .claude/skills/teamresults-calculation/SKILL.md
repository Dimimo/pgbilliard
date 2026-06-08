---
name: team-results-calculation
description: "Calculates the results of TEAMS (not INDIVIDUAL games). A game is either won or lost. The data comes from the 'events' table. The Laravel model is called Event."
---

# Team results calculation

This skill explains how the **team scoresheet** (the league standings) is calculated.
It is TEAM-based, not individual-game based: each `Event` is one team-vs-team game that is
won or lost as a whole.

## Code

- Logic lives in `app/Traits/ResultsTrait.php`. Entry point: the private method `getResults()`.
- The trait is `use`d only by the `app/Livewire/Score.php` component (the public index/scoresheet page).
- `percentage()` (the scoresheet sort key) lives in the trait and is the single source of truth.
  `$this->percentage()` on `ResultsTrait.php:135` resolves to the trait method because `Score` is the
  only consumer — it is **not** the `Team` model.

## Database

- Table `events`, model `Event` (`app/Models/Event.php`). Each event links to a `Date`
  (table `dates`, model `Date`) via `date_id`, and to two teams via `team1` / `team2`.
- Teams: model `Team`. Events are scoped to a season through their `Date`.
- See `CLAUDE.md` for the full schema and relationships.

# Domain rules

## General overview

- One playing **day** per week (`Date` model). Each day produces several `Event`s — one per a pair of teams.
- A `Date` with `regular = false`/`0` is a **normal** day: 15 games per event (race to 8 wins the event).
  `regular = true` marks a **semi-final or final**: also a race to 8.
- An `Event` has a `confirmed` flag. A confirmed event is final.
- **Scoring:** a score of **8 or more wins** the event; **7 or fewer loses** (code checks `score > 7`).
- **BYE:** when a season has an odd number of teams, one team gets a **BYE** each week (it rotates).
  A BYE is a non-game. The BYE team is **always `team2`** in the `Event`. A BYE still counts as a
  played game for the team that has it.
- **No-show ("not in"):** a recorded score of `0–0` means neither team showed up. It counts as a
  played event but adds no win and no loss.

## The percentage (success rate)

This is the **heart of the calculation** and the sort key for the standings. Calculated in
`percentage()` (`ResultsTrait.php`):

```
percentage = floor(
    ( (won / max_games) * 100  +  (for / (max_games * 15)) * 100 ) / 2 * factor
)
```

It is the **average of two rates**:

- **match-win rate** — events won out of `max_games`
- **individual-game rate** — individual games won (`for`) out of all individual games possible
  (`max_games * 15`)

The `factor` rewards reaching the final:

- `finals === 2` and won the final → `factor = 1.3`
- `finals === 2` and lost the final → `factor = 1.15`
- otherwise → `factor = 1`

If `max_games` is 0 the percentage is 0. Standings are sorted by `percentage` descending, then a
1-based `rank` is assigned.

# The array returned by `getResults()`

`getResults()` returns an **array of `Collection`s** (one per team, BYE excluded), already sorted by
percentage. Each collection is seeded by `startCollection()` and has these keys:

| key              | type / values                                                                     |
| ---------------- | --------------------------------------------------------------------------------- |
| `id`             | the last `Event` id processed for this team (null until the first event)          |
| `team`           | the `Team` model for this row                                                     |
| `played`         | the **opponent** `Team` of the most recent event (or the BYE team)                |
| `won`            | total events won                                                                  |
| `lost`           | total events lost                                                                 |
| `for`            | total individual games won (0–15 per event)                                       |
| `against`        | total individual games lost (0–15 per event)                                      |
| `games_played`   | total events played (a BYE counts as played)                                      |
| `last_result`    | **union** — see below                                                             |
| `last_game_won`  | bool — was the most recent event a win                                            |
| `percentage`     | int — success rate (see above)                                                    |
| `rank`           | int — 1-based position in the standings                                           |
| `max_games`      | max events anyone has played (grows for semis/finals where not all teams play)    |
| `finals`         | 0 = none, 1 = played a semi-final, 2 = played a final (feeds the factor)          |
| `last_play_date` | string `"M jS"` of the most recent event — **only present after ≥1 played event** |

### `last_result` is a union type

It is **not always** a score collection. It can be:

- the string `'not in'` — a 0–0 no-show
- the string `'BYE'` — the team had a BYE that week
- a `Collection` of the score, **normalized so `score1` is always THIS team and `score2` is always
  the opponent** (regardless of home/visitor). Note the visitor branch deliberately swaps the raw
  `event->score1`/`score2` to keep this orientation consistent.

# Gotchas

- **Normalized scores:** `last_result`'s `score1`/`score2` mean _this team_ / _opponent_, NOT
  _home_ / _visitor_. The home and visitor branches map the raw event scores accordingly.
- **Future-game guard (added 21/05/2026):** `maxAllowedDateForNextWeek()` stops an event that was
  scored ahead of schedule from inflating `games_played` / BYE counts before its week is reached.
  It computes the cutoff from the season's first playing weekday.
- **`max_games` can grow mid-loop:** for semis/finals not every team plays, so `max_games` increases
  when a team exceeds the running total. Teams that didn't reach those rounds get `last_game_won = false`.

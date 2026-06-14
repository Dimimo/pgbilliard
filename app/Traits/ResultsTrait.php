<?php

namespace App\Traits;

use App\Constants;
use App\Models\Date;
use App\Models\Event;
use App\Models\Team;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Context;

/**
 * Trait ResultsTrait
 *
 * The purpose of this Trait is to calculate the current state of the championship based on the Date, Team and Event models
 * The method called is getResults() returning a collection with all data ready to be printed on the scoreboard table overview
 */
trait ResultsTrait
{
    /**
     * A placeholder for the team id's
     */
    private array $teams;

    /**
     * each team has events; for the sake of simplicity we store the even here for use in other methods
     */
    private Event $event;

    /**
     * a collection where results of a SINGLE event are stored
     */
    private Collection $result;

    /**
     * the raw values of the teams (natural array) which will hold all events
     */
    private array $teams_array;

    private \Illuminate\Database\Eloquent\Collection $team_names;

    /**
     * The big one. Calculates all results for each team and each event.
     */
    private function getResults(): array
    {
        $results = collect();
        $this->getTeamsArray();
        $this->getEvents();
        $max_games = $this->played_weeks;
        $max_allowed = $this->maxAllowedDateForNextWeek();

        foreach ($this->teams as $team_id => $events) {
            $this->startResultCollection();
            $this->result->put('team', $this->team_names->find($team_id));
            foreach ($events as $this->event) {
                if ($this->isPlayedGame()) {
                    $this->populateEventToResult();
                    // team plays home
                    if ($team_id === $this->event->team_1->id) {
                        $this->teamResultsByEvent(
                            $this->event->team_2,
                            $this->event->score1,
                            $this->event->score2,
                        );
                    }
                    // team is the visitor
                    elseif ($team_id === $this->event->team_2->id) {
                        $this->teamResultsByEvent(
                            $this->event->team_1,
                            $this->event->score2,
                            $this->event->score1,
                        );
                    }
                }

                // HERE is a tricky one, to avoid that the nr 3 is higher ranked than the runner-up in the
                // scoreboard, (semi)finals add an extra game, although never played, which influences the .
                // calculation of the percentage in the next phase
                // 21/05/2026 I added an extra condition for the rare occasion a future game has been played
                //            already which resulted in unpredictable scoreboard behavior
                elseif (
                    $this->event->team_2->name === 'BYE' &&
                    $this->result->get('games_played') <= $max_games - 1 &&
                    $this->event->date->date->lt($max_allowed)
                ) {
                    $this->result->put('games_played', $this->result->get('games_played') + 1);
                    $this->result->put('played', $this->event->team_2);
                    $this->result->put('last_result', 'BYE');
                }

                // teams not participating in (semi)finals receive a negatively influenced percentage
                // by adding a game they never played to $max_games
                if ($max_games < $this->result->get('games_played')) {
                    $max_games++;
                }

                // in the DB, the field 'regular' set as TRUE means a special game, aka, a (semi)final
                // this is a mistake from my part
                // in the 'events' table the field name 'regular' should be 'special' or 'finals'
                if ($this->event->date->regular) {
                    $this->result->put('finals', $this->result->get('finals') + 1);
                }
            }

            $results->push($this->result);
        }

        // finalize the results collection by adding the percentage and max played games
        // the percentage (success rate) determines the ranking on the scoreboard
        $results->map(function ($result) use ($max_games) {
            // in case of (semi) finals, set the last result to false for teams that didn't make it
            if ($max_games > $result->get('games_played')) {
                $result->put('last_game_won', false);
            }
            $result->put('max_games', $max_games);
            $result->put('percentage', $this->percentage($result));

            return $result;
        });

        // sort the collection by percentage and return the collection to the Score Livewire component
        return $results
            ->sortByDesc('percentage', SORT_NATURAL)
            ->values()
            ->all();
    }

    /**
     * Get the Teams in the current cycle in alphabetical order
     * Flip it and prepare for the final calculation
     * Needed to loop through the teams first followed up by looping through the events (games) next
     * The events themselves are pushed into the collection in the getEvents() method
     */
    private function getTeamsArray(): void
    {
        $query = Team::query()
            ->where('season_id', Context::getHidden('season_id'))
            ->where('name', '<>', 'BYE')
            ->orderBy('name');
        $this->team_names = $query->get();
        $this->teams_array = $query->pluck('id')->toArray();
        $this->teams = array_flip($this->teams_array);

        foreach ($this->teams as $id => $team) {
            $this->teams[$id] = [];
        }
    }

    /**
     * Get all events, pushes the results in $this->teams
     */
    private function getEvents(): void
    {
        $dates = Date::query()
            ->where('season_id', Context::getHidden('season_id'))
            ->with(['events.date', 'events.team_1', 'events.team_2'])
            ->get();

        $dates->each(function (Date $date): void {
            $date->events->each(function ($event): void {
                if (in_array($event->team_1->id, $this->teams_array)) {
                    $this->teams[$event->team_1->id][] = $event;
                }
                if (in_array($event->team_2->id, $this->teams_array)) {
                    $this->teams[$event->team_2->id][] = $event;
                }
            });
        });
    }

    /**
     * explanation: some games are not played on the planned day of the week (captains can agree on that)
     * in the rare case, some games are played more than a week in advance, resulting in abnormal scoreboard behavior
     * */
    private function maxAllowedDateForNextWeek(): \Illuminate\Support\Carbon
    {
        $day_of_week = Date::query()
            ->where('season_id', Context::getHidden('season_id'))
            ->first()
            ->date->dayOfWeek();
        return \Illuminate\Support\Facades\Date::now()->next($day_of_week)->subDays(3);
    }

    /**
     * Returns a collection, is called for the calculation of every other team in the calculation loop
     */
    private function startResultCollection(): void
    {
        $this->result = collect();
        $this->result->put('id', null);
        $this->result->put('team', 'my team');
        $this->result->put('played', null);
        $this->result->put('won', 0);
        $this->result->put('lost', 0);
        $this->result->put('for', 0);
        $this->result->put('against', 0);
        $this->result->put('games_played', 0);
        $this->result->put('last_result', collect());
        $this->result->put('last_game_won', false);
        $this->result->put('percentage', 0);
        $this->result->put('max_games', 0);
        $this->result->put('finals', 0);
    }

    /**
     * Checks if a game is really played and not a BYE
     * remark: a NULL means a future game, 0-0 means a planned game but no scores are given yet
     *
     * @return bool
     */
    private function isPlayedGame(): bool
    {
        return !is_null($this->event->score1) &&
            !is_null($this->event->score2) &&
            $this->event->team_2->name !== 'BYE';
    }

    /**
     * Every played game (Event) has a fixed set of (result) settings
     *
     * @return void
     */
    private function populateEventToResult(): void
    {
        $this->result->put('id', $this->event->id);
        $this->result->put('last_game_won', false);
        $this->result->put('games_played', $this->result->get('games_played') + 1);
        $this->result->put('last_play_date', $this->event->date->date);
    }

    /**
     * the method that puts the event data in the proper $this->result context (win, loss, group and individual scores)
     * */
    private function teamResultsByEvent(Team $opponent, int $myScore, int $opponentScore): void
    {
        $this->result->put('played', $opponent);
        $this->result->put('for', $this->result->get('for') + $myScore);
        $this->result->put('against', $this->result->get('against') + $opponentScore);

        //in case of 'not in' 0-0 (a planned game but no scores yet)
        if ($myScore === 0 && $opponentScore === 0) {
            $this->result->put('last_result', 'not in');
        } else {
            $this->result->put(
                'last_result',
                collect([
                    'score1' => $myScore,
                    'score2' => $opponentScore,
                ]),
            );
        }

        // checks if the game is won
        // also checks the rare occasion of a played game that ends of a team losing all games
        if ($myScore > 7) {
            $this->result->put('won', $this->result->get('won') + 1);
            $this->result->put('last_game_won', true);
        } elseif (
            // a fix in case of a score of 0-15 or 0-8, shouldn't be mixed up with a no show
            ($myScore > 0 && $opponentScore > 0) ||
            ($myScore === 0 && $opponentScore > 7)
        ) {
            $this->result->put('lost', $this->result->get('lost') + 1);
            $this->result->put('last_game_won', false);
        }
    }

    /**
     * Calculates the percentages of a given score table of a team
     * Finalists receive an extra factor, to avoid that winners/runner ups have a lower ranking than the 3rd team
     */
    public function percentage(Collection $result): int
    {
        if (!$result->get('max_games')) {
            return 0;
        }

        // multiply the percentages with a factor for the 2 teams in the final
        $factor = 1;
        if ($result->get('finals') === 2) {
            $result->get('last_game_won')
                ? ($factor = Constants::FINALIST_MULTIPLICATION_FACTOR_WINNER)
                : ($factor = Constants::FINALIST_MULTIPLICATION_FACTOR_LOSER);
        }

        $percentage = (int) number_format(
            floor(
                ((($result->get('won') / $result->get('max_games')) * 100 +
                    ($result->get('for') / ($result->get('max_games') * 15)) * 100) /
                    2) *
                    $factor,
            ),
        );

        // in rare cases, the percentage turns out to be bigger than 100
        return min(100, $percentage);
    }
}

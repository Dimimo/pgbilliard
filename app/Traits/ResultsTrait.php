<?php

namespace App\Traits;

use App\Models\Date;
use App\Models\Event;
use App\Models\Team;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Context;

/**
 * Trait ResultsTrait
 */
trait ResultsTrait
{
    /**
     * A placeholder for the team id's
     */
    private array $teams;

    /**
     * each team has events; for the sake of simplicity we store the even data in private Event Model
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
        // 21/05/2026 I added an extra condition in case a future game has been played already
        $max_allowed_date_for_next_week = $this->maxAllowedDateForNextWeek();

        foreach ($this->teams as $team_id => $events) {
            $this->startResultCollection();
            $this->result->put('team', $this->team_names->find($team_id));
            foreach ($events as $this->event) {
                if ($this->IsPlayedGame()) {
                    $this->initiateEventToResult();
                    //team plays home
                    if ($team_id === $this->event->team_1->id) {
                        $this->result->put('played', $this->event->team_2);
                        $this->result->put('for', $this->result->get('for') + $this->event->score1);
                        $this->result->put(
                            'against',
                            $this->result->get('against') + $this->event->score2,
                        );
                        //in case of not in (0/0)
                        if ($this->event->score1 == 0 && $this->event->score2 == 0) {
                            $this->result->put('last_result', 'not in');
                        } else {
                            // $this->result->put('last_result', "$this->event->score1/$this->event->score2");
                            $this->result->put(
                                'last_result',
                                collect([
                                    'score1' => $this->event->score1,
                                    'score2' => $this->event->score2,
                                ]),
                            );
                        }
                        if ($this->event->score1 > 7) {
                            $this->result->put('won', $this->result->get('won') + 1);
                            $this->result->put('last_game_won', true);
                        } elseif (
                            // a fix in case of a score of 0-15 or 0-8, shouldn't be mixed up with a no show
                            ($this->event->score1 > 0 && $this->event->score2 > 0) ||
                            ($this->event->score1 === 0 && $this->event->score2 > 7)
                        ) {
                            $this->result->put('lost', $this->result->get('lost') + 1);
                            $this->result->put('last_game_won', false);
                        }
                    }
                    //team plays as visitor
                    elseif ($team_id === $this->event->team_2->id) {
                        $this->result->put('played', $this->event->team_1);
                        $this->result->put('for', $this->result->get('for') + $this->event->score2);
                        $this->result->put(
                            'against',
                            $this->result->get('against') + $this->event->score1,
                        );
                        //in case of not in (0/0)
                        if ($this->event->score1 == 0 && $this->event->score2 == 0) {
                            $this->result->put('last_result', 'not in');
                        } else {
                            //$this->result->put('last_result', "$this->event->score2/$this->event->score1");
                            $this->result->put(
                                'last_result',
                                collect([
                                    'score2' => $this->event->score1,
                                    'score1' => $this->event->score2,
                                ]),
                            );
                        }
                        if ($this->event->score2 > 7) {
                            $this->result->put('won', $this->result->get('won') + 1);
                            $this->result->put('last_game_won', true);
                        } elseif (
                            // a fix in case of a score of 0-15 or 0-8, shouldn't be mixed up with a no show
                            ($this->event->score1 > 0 && $this->event->score2 > 0) ||
                            ($this->event->score2 === 0 && $this->event->score1 > 7)
                        ) {
                            $this->result->put('lost', $this->result->get('lost') + 1);
                            $this->result->put('last_game_won', false);
                        }
                    }
                }
                //HERE is a tricky one, to avoid that the nr 3 is higher ranked than the runner-up
                // 21/05/2026 I added an extra condition in case a future game has been played already
                elseif (
                    $this->event->team_2->name === 'BYE' &&
                    $this->result->get('games_played') <= $max_games - 1 &&
                    $this->event->date->date->format('Y-m-d') < $max_allowed_date_for_next_week
                ) {
                    $this->result->put('games_played', $this->result->get('games_played') + 1);
                    $this->result->put('played', $this->event->team_2);
                    $this->result->put('last_result', 'BYE');
                }
                if ($max_games < $this->result->get('games_played')) {
                    $max_games++; // in case of semi and finals
                }
                $this->result->put('max_games', $max_games);
                if ($this->event->date->regular) {
                    $this->result->put('finals', $this->result->get('finals') + 1);
                }
            }
            $results->push($this->result);
        }
        //finalize the results collection
        $results->map(function ($result) use ($max_games) {
            //in case of (semi) finals, set the last result to false for teams that didn't make it
            if ($max_games > $result->get('games_played')) {
                $result->put('last_game_won', false);
            }
            $result->put('max_games', $max_games);
            $result->put('percentage', $this->percentage($result));

            return $result;
        });
        //and sort it by percentage (success rate)
        $results = $results
            ->sortByDesc('percentage', SORT_NATURAL)
            ->values()
            ->all();
        //add the real ranking to the result object
        $rank = 1;
        foreach ($results as $key => $result) {
            $result->put('rank', $rank);
            $rank++;
            $results[$key] = $result;
        }

        return $results;
    }

    /**
     * Get the Teams in the current cycle in alphabetical order
     * Flip it and prepare for the final calculation
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

    private function maxAllowedDateForNextWeek(): string
    {
        $first_date = Date::query()->where('season_id', Context::getHidden('season_id'))->first();
        $day_of_week = \Illuminate\Support\Facades\Date::createFromFormat(
            'Y-m-d',
            $first_date->date->format('Y-m-d'),
        )->dayOfWeek();
        return \Illuminate\Support\Facades\Date::now()
            ->next($day_of_week)
            ->subDays(3)
            ->format('Y-m-d');
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
        $this->result->put('rank', 0);
        $this->result->put('max_games', 0);
        $this->result->put('finals', 0);
    }

    /**
     * Checks if a game is really played, or future (NULL) or planned
     * @return bool
     */
    private function IsPlayedGame(): bool
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
    public function initiateEventToResult(): void
    {
        $this->result->put('id', $this->event->id);
        $this->result->put('last_game_won', false);
        $this->result->put('games_played', $this->result->get('games_played') + 1);
        $this->result->put('last_play_date', $this->event->date->date);
    }

    /**
     * Calculates the percentages of a given score table of a team
     */
    public function percentage(Collection $result): int
    {
        if (!$result->get('max_games')) {
            return 0;
        }

        // multiply the percentages with a factor for the 2 teams in the final
        $factor = 1;
        if ($result->get('finals') === 2) {
            $result->get('last_game_won') ? ($factor = 1.3) : ($factor = 1.15);
        }

        return (int) number_format(
            floor(
                ((($result->get('won') / $result->get('max_games')) * 100 +
                    ($result->get('for') / ($result->get('max_games') * 15)) * 100) /
                    2) *
                    $factor,
            ),
        );
    }
}

<?php

namespace App\Traits;

use App\Models\Date;
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

        foreach ($this->teams as $team_id => $events) {
            $result = $this->startCollection();
            $result->put('team', $this->team_names->find($team_id));
            foreach ($events as $event) {
                if (!is_null($event->score1) && !is_null($event->score2) && $event->team_2->name !== 'BYE') {
                    $result->put('id', $event->id);
                    $result->put('last_game_won', false);
                    $result->put('games_played', $result->get('games_played') + 1);
                    //team plays home
                    if ($team_id === $event->team_1->id) {
                        $result->put('played', $event->team_2);
                        $result->put('for', $result->get('for') + $event->score1);
                        $result->put('against', $result->get('against') + $event->score2);
                        //in case of not in (0/0)
                        if ($event->score1 == 0 && $event->score2 == 0) {
                            $result->put('last_result', 'not in');
                        } else {
                            // $result->put('last_result', "$event->score1/$event->score2");
                            $result->put('last_result', collect(['score1' => $event->score1, 'score2' => $event->score2]));
                        }
                        if ($event->score1 > 7) {
                            $result->put('won', $result->get('won') + 1);
                            $result->put('last_game_won', true);
                        } elseif (
                            // a fix in case of a score of 0-15 or 0-8, shouldn't be mixed up with a no show
                            ($event->score1 > 0 && $event->score2 > 0)
                            ||
                            ($event->score1 === 0 && $event->score2 > 7)
                        ) { //in case of not-in (0-0)
                            $result->put('lost', $result->get('lost') + 1);
                            $result->put('last_game_won', false);
                        }
                    } //team plays as visitor
                    elseif ($team_id === $event->team_2->id) {
                        $result->put('played', $event->team_1);
                        $result->put('for', $result->get('for') + $event->score2);
                        $result->put('against', $result->get('against') + $event->score1);
                        //in case of not in (0/0)
                        if ($event->score1 == 0 && $event->score2 == 0) {
                            $result->put('last_result', 'not in');
                        } else {
                            //$result->put('last_result', "$event->score2/$event->score1");
                            $result->put('last_result', collect(['score2' => $event->score1, 'score1' => $event->score2]));
                        }
                        if ($event->score2 > 7) {
                            $result->put('won', $result->get('won') + 1);
                            $result->put('last_game_won', true);
                        } elseif ($event->score1 !== 0 && $event->score2 !== 0) { //in case of not-in (0-0) which is not a loss
                            $result->put('lost', $result->get('lost') + 1);
                            $result->put('last_game_won', false);
                        }
                    }
                } //HERE is a tricky one, to avoid that the nr 3 is higher ranked than the runner-up
                elseif (($event->team_2->name === 'BYE') && ($result->get('games_played') <= ($max_games - 1))) {
                    $result->put('games_played', $result->get('games_played') + 1);
                    $result->put('played', $event->team_2);
                    $result->put('last_result', 'BYE');
                }
                if ($max_games < $result->get('games_played')) {
                    $max_games++; // in case of semi and finals
                }
                $result->put('max_games', $max_games);
                if ($event->date->regular) {
                    $result->put('finals', $result->get('finals') + 1);
                }
            }
            $results->push($result);
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
        $results = $results->sortByDesc('percentage', SORT_NATURAL)->values()->all();
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
     * Get all events, pushes the results in $this->>teams
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
     * Returns a collection, is called for the calculation of every other team in the calculation loop
     */
    private function startCollection(): Collection
    {
        $collection = collect();
        $collection->put('id', null);
        $collection->put('team', 'my team');
        $collection->put('played', null);
        $collection->put('won', 0);
        $collection->put('lost', 0);
        $collection->put('for', 0);
        $collection->put('against', 0);
        $collection->put('games_played', 0);
        $collection->put('last_result', collect());
        $collection->put('last_game_won', false);
        $collection->put('percentage', 0);
        $collection->put('rank', 0);
        $collection->put('max_games', 0);
        $collection->put('finals', 0);

        return $collection;
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
            $result->get('last_game_won') ? $factor = 1.3 : $factor = 1.15;
        }

        return (int)number_format(floor(((($result->get('won') / $result->get('max_games')) * 100) + ($result->get('for') / ($result->get('max_games') * 15)) * 100) / 2 * $factor));
    }
}

<?php

namespace App\Livewire;

use App\Models\Season;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

/**
 * a trait that handles adding or removing teams in the current season
 */
trait WithTeamOrdering
{
    /**
     * @var Collection
     */
    public Collection $teams;
    /**
     * a collection of possible team selection for the current season
     *
     * @var Collection
     */
    public Collection $dropdown_teams;
    /**
     * the number of teams can come from a session value or is set to an arbitrary number of teams (usually 6)
     *
     * @var int
     */
    public int $number_of_teams;
    /**
     * @var int
     */
    public int $i = 1;

    /**
     * push a selected team into the current season and sort by name
     *
     * @param Team $team
     * @return void
     */
    private function pushAndSortTeams(Team $team): void
    {
        $this->teams->push($team);
        $this->teams = $this->teams->sortBy('name', SORT_NATURAL);
        //update the dropdown and add 1 to the $i
        $this->dropdown_teams = $this->getDropdownTeams();
        $this->i++;
        $this->changeNumberOfTeams();
    }

    /**
     * Get the teams from the last 2 most recent seasons
     *
     * @return Collection
     */
    private function getDropdownTeams(): Collection
    {
        $season_ids = Season::query()->orderByDesc('cycle')->skip(1)->take(2)->pluck('id')->toArray();
        $new_team_names = Team::query()->where('season_id', $this->season->id)->pluck('name')->toArray();

        return Team::query()->whereIn('season_id', $season_ids)->whereNotIn('name', $new_team_names)->orderBy('name')->orderByDesc('season_id')->get()->unique('name');
    }

    /**
     * called if a team is added or removed
     *
     * @param bool $add
     * @return void
     */
    private function changeNumberOfTeams(bool $add = true): void
    {
        $this->number_of_teams = $add ? $this->number_of_teams + 1 : $this->number_of_teams - 1;
        session(['number_of_teams' => $this->number_of_teams]);
    }
}

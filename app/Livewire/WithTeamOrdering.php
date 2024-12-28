<?php

namespace App\Livewire;

use App\Models\Season;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

trait WithTeamOrdering
{
    public Collection $teams;
    public Collection $dropdown_teams;
    public int $number_of_teams;
    public int $i = 1;

    private function pushAndSortTeams(Team $team): void
    {
        $this->teams->push($team);
        $this->teams = $this->teams->sortBy('name', SORT_NATURAL);
        //update the dropdown and add 1 to the $i
        $this->dropdown_teams = $this->getDropdownTeams();
        $this->i++;
        $this->changeNumberOfTeams();
    }

    private function getDropdownTeams(): Collection
    {
        $season_ids = Season::orderByDesc('cycle')->skip(1)->take(2)->pluck('id')->toArray();
        $new_team_names = Team::where('season_id', $this->season->id)->pluck('name')->toArray();

        return Team::whereIn('season_id', $season_ids)->whereNotIn('name', $new_team_names)->orderBy('name')->orderByDesc('season_id')->get()->unique('name');
    }

    private function changeNumberOfTeams(bool $add = true): void
    {
        $this->number_of_teams = $add ? $this->number_of_teams + 1 : $this->number_of_teams - 1;
        session(['number_of_teams' => $this->number_of_teams]);
    }
}

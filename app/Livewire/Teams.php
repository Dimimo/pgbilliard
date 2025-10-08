<?php

namespace App\Livewire;

use App\Models\Date;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Context;
use Livewire\Component;

class Teams extends Component
{
    use WithCurrentCycle;
    use WithSetMyTeam;

    public Collection $teams;
    public Date $date;

    public function mount(): void
    {
        $this->teams = $this->getTeams();
        $this->date = Season::query()->find(Context::getHidden('season_id'))->dates()->latest()->first();
    }

    public function render(): View
    {
        return view('livewire.teams');
    }

    private function getTeams(): Collection
    {
        return Team::query()
            ->where('season_id', Context::getHidden('season_id'))
            ->where('name', '<>', 'BYE')
            ->with(['players', 'venue'])
            ->orderBy('name')
            ->get();
    }

    public function deleteTeam($id): void
    {
        $team = Team::query()->find($id);
        $this->authorize('delete', $team);
        if ($team->hasGames()) {
            return;
        }
        $team->players()->delete();
        $team->delete();
        $this->teams = $this->getTeams();
    }
}

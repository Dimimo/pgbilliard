<?php

namespace App\Livewire;

use App\Models\Date;
use App\Models\Season;
use App\Models\Team;
use App\Taps\Cycle;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
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
        $this->date = Season::whereCycle(session('cycle'))->first()->dates()->latest()->first();
    }

    public function render(): View
    {
        return view('livewire.teams');
    }

    private function getTeams(): Collection
    {
        return Team::tap(new Cycle())->where('name', '<>', 'BYE')->orderBy('name')->get();
    }

    public function deleteTeam($id): void
    {
        $team = Team::find($id);
        $this->authorize('delete', $team);
        if ($team->hasGames()) {
            return;
        }
        $team->players()->delete();
        $team->delete();
        $this->teams = $this->getTeams();
    }
}

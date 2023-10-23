<?php

namespace App\Livewire;

use App\Models\Team;
use App\Taps\Cycle;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Teams extends Component
{
    use WithCurrentCycle;

    public Team $team;

    public Collection $teams;

    public function mount()
    {
        $this->teams = $this->getTeams();
    }

    public function render(): View
    {
        return view('livewire.teams');
    }

    /*public function showTeamNameEdit($id)
    {
        dd($id);
    }*/
    private function getTeams(): Collection
    {
        return Team::tap(new Cycle())->where('name', '<>', 'BYE')->orderBy('name')->get();
    }
}

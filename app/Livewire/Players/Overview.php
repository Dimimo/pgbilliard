<?php

namespace App\Livewire\Players;

use App\Livewire\WithHasAccess;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Overview extends Component
{
    use WithHasAccess;

    public Team $team;

    public Collection $players;

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->players = $team->players()->get()->sortBy('name')->sortByDesc('captain');
    }

    public function render(): View
    {
        return view('livewire.players.overview');
    }
}

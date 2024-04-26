<?php

namespace App\Livewire\Players;

use App\Models\Team;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Overview extends Component
{
    public Team $team;

    public Collection $players;

    public function mount(Team $team): void
    {
        $this->team = $team;
        $this->players = $team->players()->get()->sortBy('name')->sortByDesc('captain');
    }

    public function render(): View
    {
        return view('livewire.players.overview');
    }
}

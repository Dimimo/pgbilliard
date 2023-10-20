<?php

namespace App\Livewire\Players;

use App\Models\Team;
use App\Traits\CalendarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Schedule extends Component
{
    use CalendarTrait;

    public Team $team;

    public Collection $dates;

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->dates = $this->getDates();
    }

    public function render(): View
    {
        return view('livewire.players.schedule');
    }

    private function getDates(): Collection
    {
        return $this->dates = $this->getCalendar();
    }
}

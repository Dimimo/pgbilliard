<?php

namespace App\Livewire;

use App\Traits\CalendarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Calendar extends Component
{
    use CalendarTrait, WithCurrentCycle, WithSetMyTeam;

    public Collection $dates;

    public function mount()
    {
        $this->dates = $this->getCalendar();
    }

    public function updatedWithSetMyTeam()
    {
        $this->dates = $this->getCalendar();
    }

    public function render(): View
    {
        return view('livewire.calendar');
    }
}

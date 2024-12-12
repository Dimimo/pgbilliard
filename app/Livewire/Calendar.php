<?php

namespace App\Livewire;

use App\Traits\CalendarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Calendar extends Component
{
    use CalendarTrait;
    use WithCurrentCycle;
    use WithHasAccess;
    use WithSetMyTeam;

    public Collection $dates;

    public function mount(): void
    {
        $this->dates = $this->getCalendar();
    }

    public function updatedWithSetMyTeam(): void
    {
        $this->dates = $this->getCalendar();
    }

    public function render(): View
    {
        return view('livewire.calendar');
    }
}

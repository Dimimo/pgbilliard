<?php

namespace App\Livewire;

use App\Models\Date;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DayScore extends Component
{
    use WithCurrentCycle;

    public Date $date;

    public function mount(Date $date): void
    {
        $this->date = $date;
    }

    public function render(): View
    {
        return view('pool::livewire.day-score');
    }
}

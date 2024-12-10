<?php

namespace App\View\Components;

use App\Livewire\WithCurrentCycle;
use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    use WithCurrentCycle;

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // return view('layouts.app');
        return view('livewire.score');
    }
}

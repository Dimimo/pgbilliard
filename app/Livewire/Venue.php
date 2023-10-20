<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Venue extends Component
{
    public \App\Models\Venue $venue;

    public function mount(\App\Models\Venue $venue)
    {
        $this->venue = $venue;
    }

    public function render(): View
    {
        return view('livewire.venue');
    }
}

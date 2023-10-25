<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Venue extends Component
{
    public \App\Models\Venue $venue;

    public ?string $title = null;

    public function mount(\App\Models\Venue $venue, $title)
    {
        $this->venue = $venue;
        $this->title = $title;
    }

    public function render(): View
    {
        return view('livewire.venue');
    }
}

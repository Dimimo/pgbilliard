<?php

namespace App\Livewire;

use App\Models\Venue as VenueModel;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Venue extends Component
{
    public VenueModel $venue;

    public function mount(VenueModel $venue)
    {
        $this->venue = $venue;
    }

    public function render(): View
    {
        return view('livewire.venue');
    }
}

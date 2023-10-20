<?php

namespace App\Livewire\Snippets;

use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class VenueSelect extends Component
{
    public Collection $venues;

    public function mount()
    {
        $this->venues = Venue::orderBy('name')->get();
    }

    public function render(): View
    {
        return view('livewire.snippets.venue-select');
    }
}

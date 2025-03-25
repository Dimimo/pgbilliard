<?php

namespace App\Livewire;

use App\Models\Season;
use Illuminate\Support\Collection;
use Livewire\Component;

class Rank extends Component
{
    public Collection $results;
    public int $rank = 1;

    public function mount(): void
    {
        $season = Season::where('cycle', session('cycle'))->first();
        $this->results = $season->ranks()->orderByDesc('percentage')->get();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.rank');
    }
}

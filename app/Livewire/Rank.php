<?php

namespace App\Livewire;

use App\Jobs\UpdateRanks;
use App\Models\Season;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Rank extends Component
{
    public Collection $results;
    public Season $season;
    public int $rank = 1;

    public function mount(): void
    {
        $this->season = Season::where('cycle', session('cycle'))->first();
        $this->results = $this->season->ranks()->orderByDesc('percentage')->get();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.rank');
    }

    public function requestUpdate(): void
    {
        UpdateRanks::dispatchSync($this->season);
        $this->dispatch('updated');
    }

    #[On('echo:refresh-requested,RefreshRequested')]
    public function refreshRequested(): void
    {
        $this->results = $this->season->ranks()->orderByDesc('percentage')->get();
        $this->dispatch('refresh-requested');
    }
}

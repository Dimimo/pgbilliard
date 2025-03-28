<?php

namespace App\Livewire;

use App\Models\Season;
use Illuminate\Support\Collection;
use Livewire\Component;

class Rank extends Component
{
    use UpdateRanksTrait;

    public Collection $results;
    public Season $season;
    public int $rank = 1;

    public function mount(): void
    {
        $this->season = Season::where('cycle', session('cycle'))->first();
        $this->getResults();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.rank');
    }

    public function requestUpdate(): void
    {
        $this->updateRanks();
        $this->dispatch('updated');
        $this->getResults();
        $this->dispatch('refresh-request')->self();
    }

    private function getResults(): void
    {
        $this->results = $this->season
            ->ranks()
            ->with('player.team')
            ->orderByDesc('percentage')
            ->get();
    }
}

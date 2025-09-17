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
    public int|float $count;
    public int|float $median;
    public bool $show_all_results = false;

    public function mount(): void
    {
        $this->season = Season::query()->where('cycle', session('cycle'))->first();
        $this->getResults();
        $this->median = $this->count = round($this->results->median('played'));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.rank');
    }

    public function toggleMedian(): void
    {
        $this->show_all_results = ! $this->show_all_results;
        $this->count = $this->show_all_results ? $this->results->count() : round($this->results->median('played'));
        $this->dispatch('changed-median');
        $this->dispatch('refresh-request')->self();
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

<?php

namespace App\Livewire;

use App\Models\Season;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
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
    public ?int $player_id = null;

    public function mount(): void
    {
        $this->season = Season::query()->where('cycle', session('cycle'))->first();
        $this->getResults();
        $this->median = $this->count = floor($this->results->median('played'));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.rank');
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div class="mt-8 text-center text-xl">... loading ...</div>
        HTML;
    }

    public function toggleMedian(): void
    {
        $this->show_all_results = ! $this->show_all_results;
        $this->count = $this->show_all_results ? $this->results->count() : floor($this->results->median('played'));
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

    public function getResults(): void
    {
        $this->results = $this->season
            ->ranks()
            ->with('player.team')
            ->orderByDesc('percentage')
            ->get();
    }

    #[On('echo:live-score,ScoreEvent')]
    public function updateLiveScores(array $response): void
    {
        if ($this->season->id === $response['season_id']) {
            $this->updateRanks();
            $this->getResults();
            $this->player_id = $response['player_id'];
            $this->dispatch('refresh-request')->self();
        }
    }
}

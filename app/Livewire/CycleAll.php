<?php

namespace App\Livewire;

use App\Models\Season;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CycleAll extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.cycle-all')->with([
            'seasons' => $this->getCycles(),
        ]);
    }

    private function getCycles(): Collection
    {
        return Season::query()
            ->visibleTo(auth()->user())
            ->distinct()
            ->withCount(['dates', 'teams'])
            ->orderByDesc('cycle')
            ->get();
    }

    public function selectedSeason(int $id): void
    {
        $season = Season::query()->visibleTo(auth()->user())->findOrFail($id);

        if ((int) session('season_id') !== $season->id) {
            session()->forget('my_team');
        }

        session()->put([
            'cycle' => $season->cycle,
            'season_id' => $season->id,
        ]);
        $this->redirect(route('scoreboard'), navigate: true);
    }
}

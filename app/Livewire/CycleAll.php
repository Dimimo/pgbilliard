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
            'seasons' => $this->getCycles()
        ]);
    }

    public function selectedSeason($id): void
    {
        $season = Season::findOrFail($id);
        session()->put('cycle', $season->cycle);
        $this->redirect(route('scoresheet'), navigate: true);
    }

    private function getCycles(): Collection
    {
        return Season::query()
            ->distinct()
            ->withCount(['dates', 'teams'])
            ->orderBy('cycle', 'desc')
            ->get();
    }
}

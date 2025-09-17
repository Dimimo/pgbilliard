<?php

namespace App\Livewire;

use App\Models\Season;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CycleSelect extends Component
{
    public Collection $cycles;
    public string $cycle = '0000/00';

    public function mount(): void
    {
        $this->cycles = $this->getCycles();
        $this->cycle = session('cycle', '0000/00');
    }

    public function render(): View
    {
        return view('livewire.cycle-select');
    }

    public function changeCycle(int $id): void
    {
        if ($id === 0) {
            $this->redirect(route('seasons'), navigate: true);
        } else {
            $season = Season::query()->findOrFail($id);
            session()->put('cycle', $season->cycle);
            $this->redirect(route('scoreboard'));
        }
    }

    private function getCycles(): Collection
    {
        return Season::query()
            ->distinct()
            ->orderBy('cycle', 'desc')
            ->limit(4)
            ->get();
    }
}

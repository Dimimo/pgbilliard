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

    public function updatedCycle($id): void
    {
        $season = Season::findOrFail($id);
        session(['success' => 'The season changed to ' . $season->cycle]);
        session()->put('cycle', $season->cycle);
        $this->redirect(route('scoresheet', ['season' => $season]), navigate: true);
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

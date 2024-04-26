<?php

namespace App\Livewire;

use App\Models\Season;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CycleSelect extends Component
{
    public array $cycles;

    public string $cycle;

    public function mount(): void
    {
        $this->cycles = $this->getCycles();
        $this->cycle = session('cycle');
    }

    public function render(): View
    {
        return view('livewire.cycle-select');
    }

    private function getCycles(): array
    {
        return Season::query()
            ->select('cycle')
            ->distinct()
            ->orderBy('cycle', 'desc')
            ->limit(4)
            ->get()
            ->pluck('cycle')
            ->toArray();
    }
}

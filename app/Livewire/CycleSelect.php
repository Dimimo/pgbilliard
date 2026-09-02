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

    private function getCycles(): Collection
    {
        return Season::query()
            ->visibleTo(auth()->user())
            ->distinct()
            ->orderByDesc('cycle')
            ->limit(4)
            ->get();
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
            $season = Season::query()->visibleTo(auth()->user())->findOrFail($id);

            if ((int) session('season_id') !== $season->id) {
                session()->forget('my_team');
            }

            session()->put(['cycle' => $season->cycle, 'season_id' => $season->id]);
            $this->redirect(route('scoreboard'));
        }
    }
}

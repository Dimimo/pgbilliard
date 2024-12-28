<?php

namespace App\Livewire;

use App\Models\Season;

trait WithCurrentCycle
{
    public ?string $cycle = null;
    public Season $season;

    public function mountWithCurrentCycle(): void
    {
        $this->cycle = $this->getCurrentCycle();
        $this->season = $this->getCycle();
    }

    private function getCurrentCycle(): string
    {
        if (! session()->exists('cycle') || is_null(session('cycle'))) {
            //when no cycle is in the session, put the most recent date cycle as a starting point
            $current_season = Season::orderByDesc('cycle')->first();
            if ($current_season) {
                session()->put('cycle', $current_season->cycle);
            }
        }

        return session('cycle');
    }

    public function getCycle(): Season
    {
        return Season::whereCycle($this->cycle)->first();
    }
}

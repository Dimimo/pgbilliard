<?php

namespace App\Livewire;

use App\Models\Season;
use Illuminate\Support\Facades\Context;

trait WithCurrentCycle
{
    public string $cycle = '';
    public Season $season;

    public function mountWithCurrentCycle(): void
    {
        $this->cycle = Context::getHidden('cycle');
        $this->season = $this->getSeason();
    }

    public function getCycle()
    {
        return $this->cycle;
    }

    public function getSeason(): Season
    {
        return Season::query()->whereCycle($this->cycle)->first();
    }
}

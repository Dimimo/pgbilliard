<?php

namespace App\Taps;

use App\Models\Season;
use Illuminate\Database\Eloquent\Builder;

final readonly class Cycle
{
    public function __invoke(Builder $builder): Builder
    {
        $season = Season::whereCycle(session('cycle'))->first();

        return $builder->where('season_id', $season?->id);
    }
}

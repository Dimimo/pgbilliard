<?php

namespace App\Traits;

use App\Models\Date;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Context;

trait CalendarTrait
{
    /**
     * @return Collection<Date>
     */
    private function getCalendar(): Collection
    {
        return Date::query()
            ->where('season_id', Context::getHidden('season_id'))
            ->with([
                'events' => fn(Relation $q) => $q->with(['date', 'team_1', 'team_2']),
            ])
            ->orderBy('date')
            ->get();
    }
}

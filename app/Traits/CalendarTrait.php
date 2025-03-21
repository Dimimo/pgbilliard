<?php

namespace App\Traits;

use App\Models\Date;
use App\Taps\Cycle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

trait CalendarTrait
{
    /**
     * @return Collection<Date>
     */
    private function getCalendar(): Collection
    {
        return Date::tap(new Cycle())->with([
            'events' => function (Relation $q) {
                return $q->with(['date', 'team_1', 'team_2']);
            },
        ])->orderBy('date')->get();
    }
}

<?php

/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace App\Traits;

use App\Models\Date;
use App\Taps\Cycle;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CalendarTrait
{
    /**
     * @return Collection<Date>
     */
    private function getCalendar(): Collection
    {
        return Date::tap(new Cycle())->with([
            'events' => function (HasMany $q) {
                return $q->with(['date', 'team_1', 'team_2']);
            },
        ])->orderBy('date')->get();
    }
}

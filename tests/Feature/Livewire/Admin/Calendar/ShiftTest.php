<?php

use App\Livewire\Admin\Calendar\Shift;
use Livewire\Livewire;

it('has dates', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $dates = \App\Models\Date::where('season_id', 1)
        ->withCount(['events' => fn ($event) => $event->where('confirmed', 1)])
        ->orderBy('date')
        ->get();
    $this->assertSame($dates->count(), 4);
    $mutable_dates = $dates->filter(fn ($date) => $date->events_count === 0);
    if ($mutable_dates->count() > 0) {
        $last_played_date = $mutable_dates->first();
    } else {
        $last_played_date = $dates->last();
    }
    $this->assertSame($last_played_date, $mutable_dates->first());
});

it('renders successfully', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $season = \App\Models\Season::find(1);
    Livewire::test(Shift::class, ['season' => $season])
        ->assertStatus(200)
        ->assertSet('season', $season)
        ->assertCount('dates', 4);
});

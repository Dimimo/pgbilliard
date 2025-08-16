<?php

use App\Livewire\Admin\Calendar\Shift;
use Livewire\Livewire;

it('renders successfully', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $season = \App\Models\Season::find(1);
    Livewire::test(Shift::class, ['season' => $season])
        ->assertStatus(200)
        ->assertSet('season', $season)
        ->assertCount('dates', 4);
});

it('has dates', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $dates = \App\Models\Date::where('season_id', 1)
        ->withCount(['events' => fn($event) => $event->where('confirmed', 1)])
        ->orderBy('date')
        ->get();
    $this->assertSame($dates->count(), 4);
    $mutable_dates = $dates->filter(fn($date) => $date->events_count === 0);
    if ($mutable_dates->count() > 0) {
        $last_played_date = $mutable_dates->first();
    } else {
        $last_played_date = $dates->last();
    }
    $this->assertSame($last_played_date, $mutable_dates->first());
});

it('can shift a date and checks for overlap', function () {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $season = \App\Models\Season::first();
    $admin = \App\Models\User::factory()->create(['name' => 'admin']);
    \App\Models\Admin::factory()->create(['user_id' => $admin->id]);
    $last_played_date = $season->dates->last();

    Livewire::actingAs($admin)
        ->test(Shift::class, ['season' => $season])
        ->call('changeDate', $last_played_date->id, -7)
        ->assertDispatched('overlaps');
});

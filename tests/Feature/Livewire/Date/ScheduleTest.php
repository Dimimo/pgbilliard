<?php

use App\Livewire\Date\Schedule;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $event = \App\Models\Event::query()->latest()->first();
    $season = $event->date->season;
    \Illuminate\Support\Facades\Context::addHidden([
        'cycle' => $season->cycle,
        'season_id' => $season->id,
    ]);

    Livewire::test(Schedule::class, ['event' => $event])
        ->assertStatus(200);
});

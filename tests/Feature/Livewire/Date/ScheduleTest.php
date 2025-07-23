<?php

use App\Livewire\Date\Schedule;
use Livewire\Livewire;

it('renders successfully', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $event = \App\Models\Event::latest()->first();

    Livewire::test(Schedule::class, ['event' => $event])
        ->assertStatus(200);
});

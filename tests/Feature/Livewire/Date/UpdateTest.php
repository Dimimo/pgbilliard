<?php

use App\Livewire\Date\Update;
use Livewire\Livewire;

it('renders successfully', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $event = \App\Models\Event::latest()->first();

    Livewire::test(Update::class, ['event' => $event])
        ->assertStatus(200);
});

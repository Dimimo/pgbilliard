<?php

use App\Livewire\Teams;
use Livewire\Livewire;

it('renders successfully', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    session()->put('cycle', \App\Models\Season::first()->cycle);

    Livewire::test(Teams::class)
        ->assertStatus(200);
});

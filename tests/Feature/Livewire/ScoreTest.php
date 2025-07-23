<?php

use App\Livewire\Score;
use Livewire\Livewire;

it('renders successfully', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    session()->put('cycle', \App\Models\Season::first()->cycle);

    Livewire::test(Score::class)
        ->assertStatus(200);
});

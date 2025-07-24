<?php

use App\Livewire\Calendar;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $season = \App\Models\Season::first();
    session()->put('cycle', $season->cycle);
    $this->component = Livewire::test(Calendar::class);
});

it('renders successfully', function () {
    $this->component
        ->assertStatus(200);
});

it('has dates', function () {
    $this->component
        ->assertViewIs('livewire.calendar')
        ->assertOk()
        ->assertViewHas('dates')
        ->assertCount('dates', 4);
});

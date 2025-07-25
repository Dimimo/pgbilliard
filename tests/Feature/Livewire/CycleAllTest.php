<?php

use App\Livewire\CycleAll;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(CycleAll::class)
        ->assertStatus(200);
});

it('shows the correct component', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $expected = "(" . \App\Models\Event::count() . " games, " . \App\Models\Team::count() . " Teams)";

    $response = $this->get('/seasons/all');
    $response
        ->assertOk()
        ->assertSeeVolt('cycle-all')
        ->assertSee(\App\Models\Season::first()->cycle)
        ->assertSee($expected);
});

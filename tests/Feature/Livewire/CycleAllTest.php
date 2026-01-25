<?php

use App\Livewire\CycleAll;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(CycleAll::class)
        ->assertStatus(200);
});

it('shows the correct component', function (): void {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $expected = "(" . \App\Models\Event::query()->count() . " games";

    $response = $this->get('/seasons');
    $response
        ->assertOk()
        ->assertSeeVolt('cycle-all')
        ->assertSee(\App\Models\Season::query()->first()->cycle)
        ->assertSee($expected);
});

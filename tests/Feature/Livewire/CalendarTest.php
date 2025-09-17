<?php

use App\Livewire\Calendar;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $season = \App\Models\Season::query()->first();
    session()->put('cycle', $season->cycle);
    $this->component = Livewire::test(Calendar::class);
});

it('shows the correct component', function () {
    $response = $this->get('/calendar');

    $response
        ->assertOk()
        ->assertSeeVolt('calendar');
});

it('renders successfully', function () {
    $this->component
        ->assertStatus(200);
});

it('shows the correct view', function () {
    $this->component
        ->assertViewIs('livewire.calendar');
});

it('has dates and the correct count', function () {
    $this->component
        ->assertViewHas('dates')
        ->assertCount('dates', 4);
});

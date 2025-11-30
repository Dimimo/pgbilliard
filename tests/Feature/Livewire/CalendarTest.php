<?php

use App\Livewire\Calendar;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $season = \App\Models\Season::query()->first();
    session()->put('cycle', $season->cycle);
    $this->component = Livewire::test(Calendar::class);
});

it('shows the correct component', function (): void {
    $response = $this->get('/calendar');

    $response
        ->assertOk()
        ->assertSeeVolt('calendar');
});

it('renders successfully', function (): void {
    $this->component
        ->assertStatus(200);
});

it('shows the correct view', function (): void {
    $this->component
        ->assertViewIs('livewire.calendar');
});

it('has dates and the correct count', function (): void {
    $this->component
        ->assertViewHas('dates')
        ->assertCount('dates', 4);
});

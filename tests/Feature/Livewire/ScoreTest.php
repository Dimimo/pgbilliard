<?php

use App\Livewire\Score;
use Livewire\Livewire;

it('renders successfully', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    session()->put('cycle', \App\Models\Season::first()->cycle);

    Livewire::test(Score::class)
        ->assertStatus(200)
        ->assertSeeVolt('score');
});

it('loads the score and rank components', function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    session()->put('cycle', \App\Models\Season::first()->cycle);

    $response = $this->get('/');

    $response
        ->assertOk()
        ->assertSeeVolt('score')
        ->assertSeeVolt('rank')
        ->assertSee('Competition Results')
        ->assertSee('Season ' . session('cycle'));
});

it('shows the score board of a full Season in the correct order', function () {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    session()->put('cycle', \App\Models\Season::first()->cycle);
    $team_names = \App\Models\Team::where('name', '<>', 'BYE')
        ->orderBy('name')
        ->get()
        ->pluck('name')
        ->toArray();

    $response = $this->get('/');

    $response->assertSeeInOrder($team_names);
});

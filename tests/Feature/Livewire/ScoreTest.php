<?php

use App\Livewire\Score;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $season = \App\Models\Season::first();
    Context::addHidden([
        'cycle' => $season->cycle,
        'season_id' => $season->id,
    ]);
});

it('renders successfully', function (): void {
    Livewire::test(Score::class)
    ->assertStatus(200)
    ->assertSeeVolt('score');
});

it('loads the score and rank components', function (): void {
    $response = $this->get('/');

    $response
        ->assertOk()
        ->assertSeeVolt('score')
        ->assertSeeVolt('rank')
        ->assertSee('Competition Results')
        ->assertSee('Season ' . session('cycle'));
});

it('shows the score board of a full Season in the correct order', function (): void {
    $team_names = \App\Models\Team::query()->where('name', '<>', 'BYE')
        ->orderBy('name')
        ->get()
        ->pluck('name')
        ->toArray();

    Livewire::withoutLazyLoading()
        ->test(Score::class)
        ->assertSeeInOrder($team_names);
});

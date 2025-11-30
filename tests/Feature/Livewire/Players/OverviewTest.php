<?php

use App\Livewire\Players\Overview;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $team = \App\Models\Team::query()->find(1);

    Livewire::test(Overview::class, ['team' => $team])
        ->assertStatus(200)
        ->assertCount('players', 4)
        ->assertSet('team', $team);
});

it('shows player names', function (): void {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $team = \App\Models\Team::query()->find(1);
    Livewire::test(Overview::class, ['team' => $team])
        ->assertSee('user 1 team 1');
});

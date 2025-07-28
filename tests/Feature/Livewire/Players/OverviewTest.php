<?php

use App\Livewire\Players\Overview;
use Livewire\Livewire;

it('renders successfully', function () {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $team = \App\Models\Team::find(1);

    Livewire::test(Overview::class, ['team' => $team])
        ->assertStatus(200)
        ->assertCount('players', 4)
        ->assertSet('team', $team);
});

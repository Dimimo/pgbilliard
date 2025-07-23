<?php

use App\Livewire\Team\Edit;
use Livewire\Livewire;

it('renders successfully', function () {
    $team = \App\Models\Team::factory()->create();

    Livewire::test(Edit::class)
        ->assertStatus(200);
});

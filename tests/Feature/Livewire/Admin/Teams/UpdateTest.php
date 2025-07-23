<?php

use App\Livewire\Admin\Teams\Update;
use Livewire\Livewire;

it('renders successfully', function () {
    $team = \App\Models\Team::factory()->create();
    Livewire::test(Update::class, ['team' => $team])
        ->assertStatus(200);
});

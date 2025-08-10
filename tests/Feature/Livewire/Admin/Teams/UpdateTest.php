<?php

use App\Livewire\Admin\Teams\Update;
use Livewire\Livewire;

it('renders successfully', function () {
    $team = \App\Models\Team::factory()->create();
    Livewire::test(Update::class, ['team' => $team])
        ->assertStatus(200);
});

it('can update a team', function () {
    $team = \App\Models\Team::factory()->create(['name' => 'Old Name']);
    Livewire::test(Update::class, ['team' => $team])
        ->set('form.name', 'Updated Name')
        ->assertSee('Updated Name');
});

<?php

use App\Livewire\Players\Edit;
use Livewire\Livewire;

it('renders successfully', function () {
    $player = \App\Models\Player::factory()->create();

    Livewire::test(Edit::class, ['team' => $player->team])
        ->assertStatus(200);
});

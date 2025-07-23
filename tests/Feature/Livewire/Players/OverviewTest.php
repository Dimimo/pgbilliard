<?php

use App\Livewire\Players\Overview;
use Livewire\Livewire;

it('renders successfully', function () {
    $player = \App\Models\Player::factory()->create();

    Livewire::test(Overview::class, ['team' => $player->team])
        ->assertStatus(200);
});

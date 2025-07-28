<?php

use App\Livewire\Players\Accounts;
use Livewire\Livewire;

it('renders successfully', function () {
    \App\Models\Season::factory()->create();
    $player = \App\Models\Player::factory()->create();

    $response = $this->get('players/accounts');

    $response
        ->assertOk()
        ->assertSeeVolt('players.accounts');

    Livewire::test(Accounts::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.players.accounts')
        ->assertSee('Claim an open user account')
        ->assertViewHas('users');
});

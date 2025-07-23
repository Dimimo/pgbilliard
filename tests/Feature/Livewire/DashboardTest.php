<?php

use App\Livewire\Dashboard;
use Livewire\Livewire;

it('renders successfully', function () {
    $user = \App\Models\User::factory()->create();
    Livewire::actingAs($user)
        ->test(Dashboard::class)
        ->assertStatus(200);
});

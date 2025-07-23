<?php

use App\Livewire\Players\Accounts;
use Livewire\Livewire;

it('renders successfully', function () {
    \App\Models\Season::factory()->create();

    Livewire::test(Accounts::class)
        ->assertStatus(200);
});

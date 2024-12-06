<?php

use App\Livewire\Chat\Messages;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Messages::class)
        ->assertStatus(200);
});

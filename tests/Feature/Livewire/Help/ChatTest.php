<?php

use App\Livewire\Help\Chat;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Chat::class)
        ->assertStatus(200);
});

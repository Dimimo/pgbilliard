<?php

use App\Livewire\Chat\Invited;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Invited::class)
        ->assertStatus(200);
});

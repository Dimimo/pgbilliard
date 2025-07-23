<?php

use App\Livewire\Venue;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Venue::class)
        ->assertStatus(200);
});

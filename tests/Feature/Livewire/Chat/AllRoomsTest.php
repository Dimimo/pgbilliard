<?php

use App\Livewire\Chat\AllRooms;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(AllRooms::class)
        ->assertStatus(200);
});

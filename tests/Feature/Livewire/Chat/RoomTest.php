<?php

use App\Livewire\Chat\Room;
use Livewire\Livewire;

it('renders successfully', function () {
    $room = \App\Models\Chat\ChatRoom::factory()->create();
    Livewire::test(Room::class, ['chatRoom' => $room])
        ->assertStatus(200);
});

<?php

use App\Livewire\Chat\Invited;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $room = \App\Models\Chat\ChatRoom::factory()->create();
    Livewire::test(Invited::class, ['room' => $room])
        ->assertStatus(200);
});

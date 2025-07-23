<?php

use App\Livewire\Chat\Index;
use Livewire\Livewire;

it('renders successfully', function () {
    \App\Models\Chat\ChatRoom::factory()->create();
    Livewire::test(Index::class)
        ->assertStatus(200);
});

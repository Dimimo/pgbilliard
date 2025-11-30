<?php

use App\Livewire\Help\Chat;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Chat::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.help.chat');
});

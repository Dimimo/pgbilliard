<?php

use App\Livewire\Help\Teams;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Teams::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.help.teams');
});

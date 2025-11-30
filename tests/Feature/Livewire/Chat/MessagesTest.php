<?php

use App\Livewire\Chat\Messages;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Messages::class)
        ->assertStatus(200);
});

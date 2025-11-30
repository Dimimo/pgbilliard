<?php

use App\Livewire\Chat\UserSelect;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(UserSelect::class)
        ->assertStatus(200);
});

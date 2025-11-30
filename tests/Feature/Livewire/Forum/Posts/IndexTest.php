<?php

use App\Livewire\Forum\Posts\Index;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Index::class)
        ->assertStatus(200);
});

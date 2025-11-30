<?php

use App\Livewire\Forum\Comments\Index;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Index::class)
        ->assertStatus(200);
});

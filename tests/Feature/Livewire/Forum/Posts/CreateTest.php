<?php

use App\Livewire\Forum\Posts\Create;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

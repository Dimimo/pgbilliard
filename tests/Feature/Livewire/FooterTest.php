<?php

use App\Livewire\Footer;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Footer::class)
        ->assertStatus(200);
});

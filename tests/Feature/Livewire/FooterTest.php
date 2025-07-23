<?php

use App\Livewire\Footer;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Footer::class)
        ->assertStatus(200);
});

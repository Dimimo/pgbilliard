<?php

use App\Livewire\Admin\SendEmails;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(SendEmails::class)
        ->assertStatus(200);
});

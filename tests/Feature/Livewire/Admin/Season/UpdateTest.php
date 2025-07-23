<?php

use App\Livewire\Admin\Season\Update;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Update::class)
        ->assertStatus(200);
});

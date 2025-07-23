<?php

use App\Livewire\Forum\Show;
use Livewire\Livewire;

it('renders successfully', function () {
    $post = \App\Models\Forum\Post::factory()->create();

    Livewire::test(Show::class, ['post' => $post])
        ->assertStatus(200);
});

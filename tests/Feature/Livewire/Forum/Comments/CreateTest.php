<?php

use App\Livewire\Forum\Comments\Create;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $comment = \App\Models\Forum\Comment::factory()->create();

    Livewire::test(Create::class, ['comment' => $comment])
        ->assertStatus(200);
});

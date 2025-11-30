<?php

use App\Livewire\Admin\Calendar\Create;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $season = \App\Models\Season::factory()->create();
    Livewire::test(Create::class, ['season' => $season])
        ->assertStatus(302);
});

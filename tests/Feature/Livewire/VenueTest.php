<?php

use App\Livewire\Venue;
use Livewire\Livewire;

beforeEach(function () {
    $this->owner = \App\Models\User::factory()->create();
    $this->venue = \App\Models\Venue::factory()->create(['name' => 'my venue', 'user_id' => $this->owner->id]);
    session(['is_admin' => false]);
});

it('renders successfully', function () {
    Livewire::test(Venue::class)
        ->assertStatus(200);
});

it('shows the venue and it can\'t be edited', function () {
    Livewire::test(Venue::class, ['venue' => $this->venue])
        ->assertOk()
        ->assertSee('my venue')
        ->assertDontSee('Edit this venue');
});

test('if the owner has access to edit the venue', function () {
    Livewire::actingAs($this->owner)
        ->test(Venue::class, ['venue' => $this->venue])
        ->assertOk()
        ->assertSee('Edit this venue');
});

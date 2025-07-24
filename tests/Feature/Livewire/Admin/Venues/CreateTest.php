<?php

use App\Livewire\Admin\Venues\Create;
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = \App\Models\Admin::factory()->create();

    $this->component = Livewire::actingAs($this->admin->user)
        ->test(Create::class, ['venue' => new \App\Models\Venue(['name' => ''])])
        ->assertViewIs('livewire.admin.venue');
});

it('renders the component successfully', function () {
    $venue = \App\Models\Venue::factory()->create();
    Livewire::test(Create::class, ['venue' => $venue->id])
        ->assertStatus(200)
        ->assertViewIs('livewire.admin.venue')
        ->assertOk();
});

it('creating a new venue validation test', function () {
    $this->component
        ->set('venue_form.name', '')
        ->set('venue_form.address', '')
        ->call('save')
        ->assertHasErrors([
            'venue_form.name' => ['required'],
            'venue_form.address' => ['required']
        ]);
});

it('can create a new venue', function () {
    $this->component
        ->set('venue_form.name', 'my venue')
        ->set('venue_form.address', 'my address')
        ->set('venue_form.contact_name', 'my name')
        ->set('venue_form.contact_nr', '0123456789')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('venues.show', ['venue' => \App\Models\Venue::first()]))
        ->assertOk();

    $this->assertEquals(\App\Models\Venue::count(), 1);
});

it('can update an existing venue', function () {
    // uses a different LiveWire component
    $venue = \App\Models\Venue::factory()->create(['name' => 'my venue']);
    Livewire::actingAs($this->admin->user)
        ->test(\App\Livewire\Admin\Venue::class, ['venue' => $venue])
        ->assertViewIs('livewire.admin.venue')
        ->assertOk()
        ->set('venue_form.name', 'other venue')
        ->call('save')
        ->assertHasNoErrors()
        ->assertOk()
        ->assertRedirect(route('teams.index'))
        ->assertOk();

    $venue->refresh();

    $this->assertEquals($venue->name, 'other venue');
});

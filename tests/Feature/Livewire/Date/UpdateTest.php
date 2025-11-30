<?php

use App\Livewire\Date\Update;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->member = \App\Models\User::factory()->create();
    $this->seed(\Database\Seeders\EventSeeder::class);
    $this->game = \App\Models\Event::query()->find(2);
    session(['is_admin' => false]);
});

it('renders successfully', function (): void {
    Livewire::actingAs($this->member)
        ->test(Update::class, ['event' => $this->game])
        ->assertStatus(200)
        ->assertViewIs('livewire.date.update')
        ->assertViewHas('event', $this->game)
        ->assertViewHas('confirmed', false)
        ->assertViewHas('score1');
});

it('can change a score and dispatches a list refresh request', function (): void {
    Livewire::actingAs($this->member)
        ->test(Update::class, ['event' => $this->game])
        ->call('change', 'score1')
        ->assertDispatched('refresh-list')
        ->assertViewHas('score1', ++$this->game->score1);
});

it('shows errors if the score is less than 0 or more than 15', function (): void {
    Livewire::actingAs($this->member)
        ->test(Update::class, ['event' => $this->game])
        ->set('score2', 0)
        ->call('change', 'score2', 'decrement')
        ->assertViewHas('score2', -1)
        ->assertHasErrors(['score2' => ['between:0,15']])
        ->set('score2', 14)
        ->call('change', 'score2')
        ->assertHasErrors('score1');
});

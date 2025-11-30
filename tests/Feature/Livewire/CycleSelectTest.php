<?php

use App\Livewire\CycleSelect;
use Livewire\Livewire;

beforeEach(function (): void {
    \App\Models\Season::factory(4)->create();
    $this->component = Livewire::test(CycleSelect::class);
});

it('renders successfully', function (): void {
    $this->component
        ->assertStatus(200)
        ->assertOk();
});

it('shows all cycles in the right order', function (): void {
    $list = \App\Models\Season::query()
        ->distinct()
        ->orderBy('cycle', 'desc')
        ->limit(4)
        ->get()
        ->pluck('cycle')
        ->toArray();

    $this->component
        ->assertSeeInOrder($list)
        ->assertSee('All Seasons');
});

it('redirects if a season is chosen', function (): void {
    $season = \App\Models\Season::query()->find(1);
    $this->component
        ->call('changeCycle', 1)
        ->assertSessionHas('cycle', $season->cycle)
        ->assertRedirectToRoute('scoreboard');
});

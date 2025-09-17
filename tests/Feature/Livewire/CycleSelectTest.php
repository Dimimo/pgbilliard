<?php

use App\Livewire\CycleSelect;
use Livewire\Livewire;

beforeEach(function () {
    \App\Models\Season::factory(4)->create();
    $this->component = Livewire::test(CycleSelect::class);
});

it('renders successfully', function () {
    $this->component
        ->assertStatus(200)
        ->assertOk();
});

it('shows all cycles in the right order', function () {
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

it('redirects if a season is chosen', function () {
    $season = \App\Models\Season::query()->find(1);
    $this->component
        ->call('changeCycle', 1)
        ->assertSessionHas('cycle', $season->cycle)
        ->assertRedirectToRoute('scoreboard');
});

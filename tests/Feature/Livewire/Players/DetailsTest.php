<?php

use App\Livewire\Players\Details;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $rank = \App\Models\Rank::factory()->create();
    $player = $rank->player;
    $season = $rank->season;
    Context::addHidden([
        'cycle' => $season->cycle,
        'season_id' => $season->id,
    ]);

    Livewire::test(Details::class, ['player' => $player])
        ->assertStatus(200)
        ->assertSeeVolt('players.details')
        ->assertViewIs('livewire.players.details')
        ->assertViewHas(['player', 'games', 'rank', 'date'])
        ->assertSee('Individual Games and Results')
        ->assertSee($player->name);
});

<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Player;

class PlayerManager
{
    public function __construct(public Event $event)
    {
    }

    public function getPlayersFromFinishedGame(): array
    {
        foreach ([0 => 'home_players', 1 => 'visit_players'] as $home => $players) {
            $player_ids = $this->event
                ->games()
                ->select('player_id')
                ->whereBetween('position', [1, 15])
                ->whereHome($home)
                ->orderBy('position')
                ->groupBy(['player_id'])
                ->get()
                ->pluck('player_id')
                ->toArray();

            ${$players} = Player::query()->whereIn('id', $player_ids)->get();
        }
        return [$home_players, $visit_players];
    }

    public function getPlayersFromUnfinishedGame(): array
    {
        $home_players = $this->event
            ->team_1
            ->activePlayers()
            ->sortBy('name');

        $visit_players = $this->event
            ->team_2
            ->activePlayers()
            ->sortBy('name');

        return [$home_players, $visit_players];
    }
}

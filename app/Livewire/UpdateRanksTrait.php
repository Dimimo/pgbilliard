<?php

namespace App\Livewire;

use App\Models\Date;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Rank;
use Illuminate\Database\Eloquent\Collection;

trait UpdateRanksTrait
{
    private Collection $players;
    private int $max_possible_games = 0;

    private function updateRanks(): void
    {
        $this->populateData();
        $this->updateRankTable();
    }

    private function populateData(): void
    {
        $teams_count = $this->season->teams()->count();
        $dates = Date::whereSeasonId($this->season->id)->orderBy('date')->pluck('id');
        $event_ids = Event::whereIn('date_id', $dates)->whereNotNull(['score1', 'score2'])->pluck('id');
        $this->max_possible_games = count($event_ids) / $teams_count * 2;
        $player_ids = Game::whereIn('event_id', $event_ids)->whereNotNull('player_id')->pluck('player_id')->unique();
        $this->players = Player::whereIn('players.id', $player_ids)
            ->withCount([
                'games as games_won' => fn ($q) => $q->where('win', true),
                'games as games_lost' => fn ($q) => $q->whereNotNull('win')->where('win', false),
                'games as games_played' => fn ($q) => $q->whereIn('event_id', $event_ids),
            ])
            ->with('user')
            ->orderByDesc('games_won')
            ->get()
            ->each(fn ($player) => $player->participation = $player->participation());
    }

    private function updateRankTable(): void
    {
        // as all data is rewritten, we delete all data of the current Season
        Rank::whereSeasonId($this->season->id)->delete();

        $insert = [
            'season_id' => $this->season->id,
            'max_games' => $this->max_possible_games
        ];

        foreach ($this->players as $player) {
            if (!$player->games_won) {
                $score = 0;
            } else {
                $score = $player->games_won / ($player->games_won + $player->games_lost) * ($player->participation / $this->max_possible_games) * 100;
                $score = round($score);
            }

            $insert = array_merge($insert, [
                'player_id' => $player->id,
                'user_id' => $player->user_id,
                'participated' => $player->participation,
                'won' => $player->games_won,
                'lost' => $player->games_lost,
                'played' => $player->games_played,
                'percentage' => $score,
            ]);

            $player->ranks()->save(new Rank($insert));
        }
    }
}

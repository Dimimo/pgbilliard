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
    /**
     * @var Collection<Player>
     */
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
        $insert = [
            'season_id' => $this->season->id,
            'max_games' => $this->max_possible_games
        ];

        foreach ($this->players as $player) {
            $insert = array_merge($insert, [
                'player_id' => $player->id,
                'user_id' => $player->user_id,
                'participated' => $player->participation,
                'won' => $player->games_won,
                'lost' => $player->games_lost,
                'played' => $player->games_played,
                'percentage' => 0,
            ]);

            Rank::updateOrCreate(
                ['season_id' => $this->season->id, 'player_id' => $player->id],
                $insert
            );
        }

        // we add the percentage this way, the calculation takes participation and played games into account
        $adjusted_percentage = $this->finalAdjustedPercentage();
        foreach ($adjusted_percentage as $player_id => $percentage) {
            Rank::whereSeasonId($this->season->id)
                ->wherePlayerId($player_id)
                ->update(['percentage' => $percentage * 100]);
        }
    }

    private function finalAdjustedPercentage(): array
    {
        // OVER () * (won / played) works as long as the first player has the most wins ('games_won')
        return Rank::selectRaw("player_id,
                ((won / played) * (participated / max_games)) /
                MAX((won / played) * (participated / max_games))
                OVER () AS percentage")
            ->whereSeasonId($this->season->id)
            ->where('played', '>', 0)
            ->orderByDesc('percentage')
            ->pluck('percentage', 'player_id')
            ->toArray();
    }
}

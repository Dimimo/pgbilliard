<?php

namespace App\Jobs;

use App\Models\Date;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Season;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class UpdateRanks implements ShouldQueue
{
    use Queueable;
    use Dispatchable;

    public Collection $players;
    public int $max_possible_games = 0;

    /**
     * Create a new job instance.
     */
    public function __construct(public Season $season)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->populateData();
        $this->updateRankTable();
        Log::info('[UpdateRanks] job executed');
    }

    private function populateData(): void
    {
        $teams_count = $this->season->teams()->count();
        $dates = Date::whereSeasonId($this->season->id)->orderBy('date')->pluck('id');
        $event_ids = Event::whereIn('date_id', $dates)->whereNotNull(['score1', 'score2'])->pluck('id');
        $this->max_possible_games = count($event_ids) / $teams_count * 2;
        // $games_played_count = Game::whereIn('event_id', $event_ids)->whereNotNull('player_id')->whereNotNull('win')->pluck('player_id')->count();
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

            $player->ranks()->updateOrCreate($insert);
        }
    }
}

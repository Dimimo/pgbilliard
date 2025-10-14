<?php

namespace App\Services;

use App\Models\Date;
use App\Models\Event;
use App\Models\Player;
use App\Models\Rank;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class RankUpdater
{
    /**
     * @var Collection<Player>
     */
    public Collection $players;
    protected int $seasonId;

    public function __construct(int $seasonId)
    {
        $this->seasonId = $seasonId;
    }

    public function update(): void
    {
        $this->populateData();
        $this->updateRankTable();
    }

    /**
     * First we have to prepare the data before we can enter the completed set to the database
     * A season has dates, dates, have events, events have players, players have games
     */
    protected function populateData(): void
    {
        $dateIds = Date::query()->whereSeasonId($this->seasonId)->orderBy('date')->pluck('id');
        $eventIds = Event::query()->whereIn('date_id', $dateIds)->whereNotNull(['score1', 'score2'])->pluck('id');

        $this->players = Player::query()
            //->whereIn('players.id', $player_ids)
            ->whereHas('games', fn ($q) => $q->whereIn('event_id', $eventIds)->whereNotNull('win'))
            ->withCount([
                'games as games_won' => fn (Builder $q) => $q->where('win', true)->whereIn('event_id', $eventIds),
                'games as games_lost' => fn (Builder $q) => $q->where('win', false)->whereIn('event_id', $eventIds),
                'games as games_played' => fn (Builder $q) => $q->whereIn('event_id', $eventIds)->whereNotNull('win'),
                'events as participated' => fn (Builder $q) => $q->whereIn('id', $eventIds)->distinct(),
            ])
            ->with(['user', 'team'])
            ->get();
    }

    protected function updateRankTable(): void
    {
        if ($this->players->isEmpty()) {
            return;
        }

        $maxPlayedGames = $this->players->max('games_played');
        $maxParticipated = $this->players->max('participated');

        $baseData = [
            'season_id' => $this->seasonId,
            'max_games' => $maxPlayedGames,
            'max_days' => $maxParticipated,
        ];

        $groupedByUser = $this->players->groupBy('user_id');

        $rankData = $groupedByUser->map(function ($players, $userId) use ($baseData, $maxParticipated) {
            $activePlayer = $players->firstWhere('active', true) ?? $players->first();

            $won = $players->sum('games_won');
            $lost = $players->sum('games_lost');
            $played = $players->sum('games_played');
            $participated = $players->sum('participated');

            $percentage = 0;
            if ($played > 0 && $maxParticipated > 0) {
                $percentage = ceil(($won / $played) * 100 * ($participated / $maxParticipated));
            }

            return array_merge($baseData, [
                'player_id' => $activePlayer->id,
                'user_id' => $userId,
                'won' => $won,
                'lost' => $lost,
                'played' => $played,
                'participated' => $participated,
                'percentage' => $percentage,
            ]);
        })->sortByDesc('played');

        foreach ($rankData as $data) {
            Rank::query()->updateOrInsert(
                [
                    'season_id' => $data['season_id'],
                    'player_id' => $data['player_id'],
                    'user_id' => $data['user_id'],
                ],
                collect($data)->except(['season_id', 'player_id', 'user_id', 'max_days'])->toArray()
            );
        }
    }
}

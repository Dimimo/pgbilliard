<?php

namespace App\Livewire;

use App\Models\Date;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Rank;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait UpdateRanksTrait
{
    /**
     * @var Collection<Player>
     */
    public Collection $players;

    private function updateRanks(): void
    {
        $this->populateData();
        $this->updateRankTable();
    }

    /**
     * First we have to prepare the data before we can enter the completed set to the database
     * A season has dates, dates, have events, events have players, players have games
     */
    private function populateData(): void
    {
        $date_ids = Date::whereSeasonId($this->season->id)->orderBy('date')->pluck('id');
        $event_ids = Event::whereIn('date_id', $date_ids)->whereNotNull(['score1', 'score2'])->pluck('id');
        $player_ids = Game::whereIn('event_id', $event_ids)->whereNotNull('player_id')->distinct()->pluck('player_id');
        $this->players = Player::whereIn('players.id', $player_ids)
            ->withCount([
                'games as games_won' => fn (Builder $q) => $q->where('win', true),
                'games as games_lost' => fn (Builder $q) => $q->whereNotNull('win')->where('win', false),
                'games as games_played' => fn (Builder $q) => $q->whereIn('event_id', $event_ids)->whereNotNull('win'),
            ])
            ->with(['user', 'team'])
            ->orderByDesc('user_id')
            ->get()
            ->each(fn ($player) => $player->participation = $player->participation());
    }

    private function updateRankTable(): void
    {
        $max_played_games = $this->players->sortByDesc('games_played')->first()->games_played;

        $insert = [
            'season_id' => $this->season->id,
            'max_games' => $max_played_games
        ];

        // first we group by user_id and then sum the won, lost, participated and played games
        // users can go in and out teams, leaving them with possibly several 'player' ids
        $players = $this->players->groupBy('user_id');
        $merged = collect();

        foreach ($players as $player) {
            $data = collect(
                array_merge($insert, [
                    'player_id' => $player->where('active', true)->first()?->id
                        ?: $player->first()->id,
                    'user_id' => $player->first()->user_id,
                    'participated' => $player->sum('participation'),
                    'won' => $player->sum('games_won'),
                    'lost' => $player->sum('games_lost'),
                    'played' => $player->sum('games_played'),
                ])
            );

            $merged->push($data);
        }

        $merged = $merged->sortByDesc('played');
        Rank::whereSeasonId($this->season->id)->delete();

        foreach ($merged as $data) {
            try {
                $percentage = ($data->get('won') / $data->get('played')) * 100;
            } catch (\DivisionByZeroError) {
                $percentage = 0;
            }
            $data->put('percentage', ($percentage));

            Rank::create($data->toArray());
        }
    }
}

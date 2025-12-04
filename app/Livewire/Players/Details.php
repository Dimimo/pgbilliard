<?php

namespace App\Livewire\Players;

use App\Models\Date;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Season;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Context;
use Livewire\Component;

class Details extends Component
{
    public Player $player;
    public Collection $games;
    public Season $season;
    public int $rank = 0;
    public ?Carbon $date = null;
    private array $date_ids;
    private array $event_ids;
    public bool $new_date = true;

    public function mount(Player $player): void
    {
        $this->player = $player->load(['team', 'user']);
        $this->season = Season::query()->find(Context::getHidden('season_id'));
        $ranks = $this->season->ranks()->orderByDesc('percentage')->pluck('user_id')->toArray();
        $this->rank = array_search($player->user->id, $ranks) + 1;
        //$this->games = $this->player->games()->orderBy('id')->get();
        $this->getGames();
        $this->date = $this->games->first()?->event->date->date;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.players.details');
    }

    private function getGames(): void
    {
        $this->date_ids ??= Date::query()
            ->whereSeasonId($this->season->id)
            ->orderBy('date')
            ->pluck('id')->toArray();
        $this->event_ids ??= Event::query()
            ->select('id')
            ->whereIn('date_id', $this->date_ids)
            ->whereNotNull(['score1', 'score2'])
            ->pluck('id')->toArray();
        $this->games = Game::query()
            ->whereIn('event_id', $this->event_ids)
            ->with(['event.venue', 'team.venue', 'event.date', 'event.team_1', 'event.team_2', 'player'])
            ->where('user_id', $this->player->user_id)
            ->orderBy('event_id')
            ->orderBy('position')
            ->get();
    }
}

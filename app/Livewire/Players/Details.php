<?php

namespace App\Livewire\Players;

use App\Models\Date;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Season;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Details extends Component
{
    public Player $player;
    public Collection $games;
    public Season $season;
    public int $rank = 0;
    public ?Carbon $date;
    public bool $new_date = true;

    public function mount(Player $player): void
    {
        $this->player = $player;
        $this->season = Season::query()->whereCycle(session('cycle'))->first();
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
        $date_ids = Date::query()
            ->whereSeasonId($this->season->id)
            ->orderBy('date')
            ->pluck('id');
        $event_ids = Event::query()
            ->whereIn('date_id', $date_ids)
            ->whereNotNull(['score1', 'score2'])
            ->pluck('id');
        $this->games = Game::query()
            ->whereIn('event_id', $event_ids)
            ->where('user_id', $this->player->user_id)
            ->orderBy('id')
            ->get();
    }
}

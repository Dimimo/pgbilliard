<?php

namespace App\Livewire\Players;

use App\Models\Event;
use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Details extends Component
{
    public Player $player;
    public Collection $games;
    public int $rank = 0;
    public ?Carbon $date;
    public bool $new_date = true;

    public function mount(Player $player): void
    {
        $this->player = $player;
        $season = \App\Models\Season::whereCycle(session('cycle'))->first();
        $ranks = $season->ranks()->orderByDesc('percentage')->pluck('user_id')->toArray();
        $this->rank = array_search($player->user->id, $ranks) + 1;
        $this->games = $this->player->games()->orderBy('id')->get();
        $this->date = $this->games->first()?->event->date->date;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.players.details');
    }

    /*public function getPlayerName(Event $event, int $position)
    {
        return $event->games()->wherePosition($position)->where('player_id', '<>', $this->player->id)->get();
    }*/
}

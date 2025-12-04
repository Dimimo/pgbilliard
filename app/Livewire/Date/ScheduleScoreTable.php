<?php

namespace App\Livewire\Date;

use App\Events\ScoreEvent;
use App\Models\Event;
use App\Models\Format;
use App\Models\Game;
use App\Models\Player;
use App\Models\Season;
use App\Services\LiveScoreUpdater;
use App\Services\Logger\LogGames;
use App\Services\ScheduleManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Settings;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ScheduleScoreTable extends Component
{
    public Event $event;
    #[Reactive]
    public ?Format $format = null;
    #[Reactive]
    public Settings $switches;
    #[Reactive]
    public Season $season;
    public Collection $home_players;
    public Collection $visit_players;
    public Collection $home_matrix;
    public Collection $visit_matrix;

    public function mount(Season $season, Event $event, Settings $switches): void
    {
        $this->season = $season;
        $this->event = (new LiveScoreUpdater($event))->getEventScores();
        $this->switches = $switches;
        [$this->home_matrix, $this->visit_matrix] = (new ScheduleManager($this->event))->recreateMatrix();
        $this->dispatch('update-settings', specific: 'can-update-players')->to(Schedule::class);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.date.schedule-score-table')->with(['switches' => $this->switches]);
    }

    public function playerChanged(int $player_id, int $game_id): void
    {
        $player = Player::find($player_id);
        Game::query()->whereId($game_id)->update(['player_id' => $player_id, 'user_id' => $player->user_id]);
        broadcast(new ScoreEvent($this->season->id, $this->event->id))->toOthers();
    }

    public function scoreGiven(int $game_id): void
    {
        $game = Game::with(['event', 'player'])->find($game_id);
        $this->authorize('update', $game->event);

        $scoreIsTrue = $game->win === true;


        // set the home or away player(s) to reverse the previous $scoreIsTrue value
        Game::query()->where([
            ['event_id', $game->event_id],
            ['position', $game->position],
            ['home', $game->home]
        ])->update(['win' => $scoreIsTrue ? null : true]);

        // then reverse the score to the other players, mind the reversed "! $game->home" status
        // but a score to true can be set to false without changing the other score
        Game::query()->where([
            ['event_id', $game->event_id],
            ['position', $game->position],
            ['home', !$game->home]
        ])->update(['win' => $scoreIsTrue ? null : false]);

        $gamePosition = Game::query()->where([
            ['event_id', $game->event_id],
            ['position', $game->position],
        ])->get();

        // finally, update the day score in the event and log the event
        $this->event = (new LiveScoreUpdater($this->event))->getEventScores();
        $this->render();
        (new LogGames())->logGameChanges($game);

        dispatch(new \App\Jobs\UpdateRanks($this->season));
        $this->dispatch('update-settings', specific: 'can-update-players')->to(Schedule::class);
        $this->dispatch('score-updated')->to(SchedulePlayerSelector::class);
        $this->dispatch('refresh-list');
        // broadcast the event to Ably
        broadcast(new ScoreEvent($this->season->id, $this->event->id, $game->player_id, $gamePosition))->toOthers();
    }

    #[On('player-selected')]
    public function playerSelected(): void
    {
        [$this->home_matrix, $this->visit_matrix] = (new ScheduleManager($this->event))->recreateMatrix();
        $this->render();
    }

    #[On('echo:live-score,ScoreEvent')]
    public function updateLiveScores($response): void
    {
        if ($this->event->id === $response['event_id'] && app()->environment($response['environment'])) {
            $this->dispatch('update-settings', specific: 'score-set', games: $response['games']);
            $this->render();
        }
    }
}

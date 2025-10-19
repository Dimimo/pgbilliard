<?php

namespace App\Livewire\Date;

use App\Events\ScoreEvent;
use App\Models\Event;
use App\Models\Format;
use App\Models\Game;
use App\Models\Player;
use App\Models\Position;
use App\Models\Schedule as Matrix;
use App\Models\Season;
use App\Services\PlayerManager;
use App\Services\ScheduleManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Settings;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class SchedulePlayerSelector extends Component
{
    public Event $event;
    #[Reactive]
    public Settings $switches;
    #[Reactive]
    public ?Format $format = null;
    #[Reactive]
    public Season $season;
    public Collection $home_players;
    public Collection $visit_players;
    public Collection $home_matrix;
    public Collection $visit_matrix;

    public function mount(Event $event, Settings $switches): void
    {
        $this->event = $event;
        $this->switches = $switches;

        if (!$this->switches->get('chooseFormat')) {
            if (!$this->switches->get('confirmed')) {
                [$this->home_players, $this->visit_players] = (new PlayerManager($this->event))->getPlayersFromFinishedGame();
            } else {
                $this->dispatch('update-settings', specific: 'can-update-players')->to(Schedule::class);
                [$this->home_matrix, $this->visit_matrix] = (new ScheduleManager($this->event))->recreateMatrix();
                [$this->home_players, $this->visit_players] = (new PlayerManager($this->event))->getPlayersFromUnfinishedGame();
            }
        }
        $this->format = (new ScheduleManager($this->event))->setFormat();
    }

    public function render(): \Illuminate\View\View
    {
        // sometimes, when the page is long open or reloaded, the app loses these settings
        if ($this->switches->get('confirmed')) {
            [$this->home_players, $this->visit_players] = (new PlayerManager($this->event))->getPlayersFromFinishedGame();
        } else {
            [$this->home_matrix, $this->visit_matrix] = (new ScheduleManager($this->event))->recreateMatrix();
            [$this->home_players, $this->visit_players] = (new PlayerManager($this->event))->getPlayersFromUnfinishedGame();
        }

        return view('livewire.date.schedule-player-selector')->with(['switches' => $this->switches]);
    }

    public function formatIsSet(): void
    {
        $this->format = (new ScheduleManager($this->event))->setFormat();
        [$this->home_players, $this->visit_players] = (new PlayerManager($this->event))->getPlayersFromUnfinishedGame();
        $this->render();
    }

    public function playerSelected(int $player_id, int $position, string $place, ?int $previous_player_id = null): void
    {
        Position::query()->where([
            'event_id' => $this->event->id,
            'rank' => $position,
            'home' => $place === 'home',
        ])->delete();
        $team = null;

        if ($player = Player::query()->with('team')->find($player_id)) {
            Position::query()->updateOrCreate([
                'event_id' => $this->event->id,
                'rank' => $position,
                'home' => $place === 'home',
            ], ['player_id' => $player_id]);
            $team = $player->team;
        }

        if (!$team) {
            if ($place === 'home') {
                $team = $this->event->team_1;
            } else {
                $team = $this->event->team_2;
            }
        }

        $schedules = Matrix::query()->where([
            ['format_id', $this->format->id],
            ['player', $position],
            ['home', $place === 'home']
        ])
            ->orderBy('position')
            ->get();

        if (!is_null($previous_player_id)) {
            Game::query()
                ->where([
                    ['event_id', $this->event->id],
                    ['team_id', $team->id],
                    ['home', $place === 'home'],
                    ['player_id', $previous_player_id],
                ])
                ->delete();
        }

        foreach ($schedules as $schedule) {
            if ($player) {
                (new Game())->updateOrCreate(
                    [
                        'schedule_id' => $schedule->id,
                        'event_id' => $this->event->id,
                        'team_id' => $player->team_id,
                        'position' => $schedule->position,
                        'home' => $place === 'home',
                    ],
                    [
                        'player_id' => $player->id,
                        'user_id' => $player->user_id,
                    ]
                );
            }
        }

        [$this->home_matrix, $this->visit_matrix] = (new ScheduleManager($this->event))->recreateMatrix();
        $this->dispatch('player-selected')->to(ScheduleScoreTable::class);
        broadcast(new ScoreEvent($this->season->id, $this->event->id))->toOthers();
        $this->render();
    }

    // resets the selected players, before any game starts
    public function scheduleReset(string $home): void
    {
        $plays_home = $home === 'home';
        $this->event->games()->where('home', $plays_home)->delete();
        Position::query()->where([['event_id', $this->event->id], ['home', $plays_home]])->delete();
        $this->event->games()->where('position', 15)->delete();

        // if all games are deleted, show the format choices again by simply reloading the page
        // reason? there are too many resets involved over several components
        if ($this->event->games()->count() === 0) {
            $this->redirectRoute('schedule.event', ['event' => $this->event], navigate: true);
        } else {
            [$this->home_matrix, $this->visit_matrix] = (new ScheduleManager($this->event))->recreateMatrix();
            [$this->home_players, $this->visit_players] = (new PlayerManager($this->event))->getPlayersFromUnfinishedGame();
            (new ScheduleManager($this->event))->checkThirdGame($this->format);
            $this->dispatch('player-selected')->to(ScheduleScoreTable::class);
        }
    }

    #[On('score-updated')]
    #[On('echo:live-score,ScoreEvent')]
    public function checkForExternalUpdates(): void
    {
        $this->render();
    }
}

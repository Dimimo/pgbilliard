<?php

namespace App\Livewire\Date;

use App\Events\ScoreEvent;
use App\Livewire\UpdateRanksTrait;
use App\Livewire\WithCurrentCycle;
use App\Models\Event;
use App\Models\Format;
use App\Models\Game;
use App\Models\Player;
use App\Models\Position;
use App\Models\Schedule as Matrix;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Schedule extends Component
{
    use LogEventsTrait;
    use ConsolidateTrait;
    use WithCurrentCycle;
    use UpdateRanksTrait;

    public Event $event;
    public Format $format;
    public Matrix $schedule;
    public Collection $positions;
    public Collection $home_players;
    public Collection $visit_players;
    public bool $choose_format = false;
    public Collection $home_matrix;
    public Collection $visit_matrix;
    public array $rounds = [1 => 'First', 6 => 'Second', 11 => 'Last'];
    public bool $can_update_players = true;
    public bool $confirmed = false;
    public ?int $game_win_id = null;
    public ?int $game_lost_id = null;

    public function mount(): void
    {
        $this->event->loadMissing('games', 'team_1.players', 'team_2.players');
        $this->confirmed = $this->event->confirmed;

        //first check if the game is confirmed, that means the game is finished
        if ($this->confirmed) {
            $this->recreateMatrix();
            $this->home_players = $this->getPlayersFromFinishedGame(true);
            $this->visit_players = $this->getPlayersFromFinishedGame(false);
            $this->can_update_players = false;
        } elseif ($this->event->games()->whereBetween('position', [1, 15])->count() > 0) {
            // the game has started but is not finished yet
            if ($this->event->games()->whereBetween('position', [1, 15])->whereNotNull('win')->count()) {
                $this->can_update_players = false;
            }
            $this->format = $this->event->games()
                ->orderBy('position')
                ->first()
                ->schedule
                ->format;
            $this->checkThirdGame();
            $this->recreateMatrix();
            $this->getPlayersFromUnfinishedGame();
            $this->event->update(['score1' => $this->getEventScore(true), 'score2' => $this->getEventScore(false)]);
        } else {
            // the game is brand new, time to choose the format and the players
            $format = Format::all();
            if ($format->count() === 1) {
                $this->formatChosen($format->first()->id);
                $this->checkThirdGame();
                $this->recreateMatrix();
                $this->getPlayersFromUnfinishedGame();
                $this->event->refresh();
            } else {
                $this->choose_format = true;
            }
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.date.schedule');
    }

    public function formatChosen(int $id): void
    {
        $this->format = Format::find($id);
        $this->choose_format = false;
        $this->checkThirdGame();
        $this->recreateMatrix();
        $this->getPlayersFromUnfinishedGame();
        $this->event->refresh();
        $this->dispatch('format-chosen');
    }

    public function scoreGiven(int $game_id): void
    {
        $game = Game::with('event')->find($game_id);
        $this->authorize('update', $game->event);

        $score_is_true = $game->win === true;

        // set the home or away player(s) to reverse the previous $score_is_true value
        Game::where([
            ['event_id', $game->event_id],
            ['position', $game->position],
            ['home', $game->home]
        ])->update(['win' => $score_is_true ? null : true]);

        // then reverse the score to the other players, mind the reversed "! $game->home" status
        // but a score to true can be set to false without changing the other score
        Game::where([
            ['event_id', $game->event_id],
            ['position', $game->position],
            ['home', !$game->home]
        ])->update(['win' => $score_is_true ? null : false]);

        // check if this is the first score being given, if so, lock the players order
        if ($this->can_update_players && $this->event->games()->whereNotNull('win')->count()) {
            $this->can_update_players = false;
        }

        // finally, update the day score in the event and log the event
        $this->event->update(['score1' => $this->getEventScore(true), 'score2' => $this->getEventScore(false)]);
        $this->logScheduleChanges($game);
        $this->checkIfPlayersCanBeUpdated();

        $this->dispatch('refresh-list');
        broadcast(new ScoreEvent($this->event))->toOthers();

        // update the individual scores (table: Rank)
        $this->updateRanks();
    }

    public function getEventScore(bool $home): int
    {
        return $this->event->games()
            ->select('position')
            ->whereHome($home)
            ->whereWin(true)
            ->groupBy(['position'])
            ->get()->count();
    }

    public function playerSelected(int $player_id, int $position, string $place, ?int $previous_player_id = null): void
    {
        Position::where([
            'event_id' => $this->event->id,
            'rank' => $position,
            'home' => $place === 'home',
        ])->delete();
        if ($player = Player::find($player_id)) {
            Position::updateOrCreate([
                'event_id' => $this->event->id,
                'rank' => $position,
                'home' => $place === 'home',
            ], ['player_id' => $player_id]);
            $team = $player->team;
        } else {
            if ($place === 'home') {
                $team = $this->event->team_1;
            } else {
                $team = $this->event->team_2;
            }
        }

        $schedules = Matrix::where([
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
                (new Game())->create([
                    'schedule_id' => $schedule->id,
                    'event_id' => $this->event->id,
                    'team_id' => $player->team_id,
                    'player_id' => $player_id,
                    'user_id' => $player->user_id,
                    'position' => $schedule->position,
                    'home' => $place === 'home',
                ]);
            }
        }

        $this->recreateMatrix();
        $this->checkThirdGame();
        $this->getPlayersFromUnfinishedGame();
        $this->dispatch('refresh-list');
        broadcast(new ScoreEvent($this->event))->toOthers();
    }

    public function playerChanged(int $player_id, int $game_id): void
    {
        Game::whereId($game_id)->update(['player_id' => $player_id]);
        broadcast(new ScoreEvent($this->event))->toOthers();
    }

    public function scheduleReset(string $home): void
    {
        $plays_home = $home === 'home';
        $this->event->games()->where('home', $plays_home)->delete();
        Position::where([['event_id', $this->event->id], ['home', $plays_home]])->delete();
        $this->event->games()->where('position', 15)->delete();
        $this->recreateMatrix();
        $this->getPlayersFromUnfinishedGame();
        $this->dispatch('player-updated-' . $home);
    }

    private function recreateMatrix(): void
    {
        $this->home_matrix = Position::with('player.user')
            ->where([['event_id', $this->event->id], ['home', true]])
            ->orderBy('rank')
            ->get();

        $this->visit_matrix = Position::with('player.user')
            ->where([['event_id', $this->event->id], ['home', false]])
            ->orderBy('rank')
            ->get();
    }

    private function checkThirdGame(): void
    {
        if ($this->event->games()->where('position', 15)->count() === 0) {
            $schedules = $this->format->schedules()->wherePosition(15)->get();
            foreach ($schedules as $schedule) {
                $values = [
                    'schedule_id' => $schedule->id,
                    'event_id' => $this->event->id,
                    'team_id' => $schedule->home ? $this->event->team_1->id : $this->event->team_2->id,
                    'player_id' => null,
                    'user_id' => null,
                    'position' => 15,
                    'home' => $schedule->home,
                ];
                (new Game())->create($values);
            }
            $this->event->refresh();
        }
    }

    private function getPlayersFromFinishedGame(bool $home): Collection
    {
        $player_ids = $this->event
            ->games()
            ->select('player_id')
            ->whereBetween('position', [1, 15])
            ->whereHome($home)
            ->orderBy('position')
            ->groupBy(['player_id'])
            ->get()
            ->pluck('player_id')
            ->toArray();
        return Player::whereIn('id', $player_ids)->get();
    }

    private function getPlayersFromUnfinishedGame(): void
    {
        $this->home_players = $this->event
            ->team_1
            ->activePlayers()
            ->sortBy('name');

        $this->visit_players = $this->event
            ->team_2
            ->activePlayers()
            ->sortBy('name');
    }

    private function checkIfPlayersCanBeUpdated(): void
    {
        $this->can_update_players = $this->event->games()
                ->whereBetween('position', [1, 15])
                ->whereNotNull('win')
                ->count() === 0;

        $this->format = $this->event->games()
            ->orderBy('position')
            ->first()
            ->schedule
            ->format;

        $this->choose_format = false;
    }

    #[On('echo:live-score,ScoreEvent')]
    public function updateLiveScores($response): void
    {
        if ($this->event->id === $response['event']['id']) {
            $this->event->refresh();
            $this->checkIfPlayersCanBeUpdated();
            $this->game_win_id = Game::whereWin(true)->orderByDesc('updated_at')->first()?->id;
            $this->game_lost_id = Game::whereWin(false)->orderByDesc('updated_at')->first()?->id;
            $this->dispatch('refresh-list');
        }
    }
}

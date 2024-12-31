<?php

namespace App\Livewire\Date;

use App\Models\Date;
use App\Models\Event;
use App\Models\Format;
use App\Models\Game;
use App\Models\Player;
use App\Models\Schedule as Matrix;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Schedule extends Component
{
    public Event $event;
    public Format $format;
    public Matrix $schedule;
    public Collection $home_players;
    public Collection $visit_players;
    public bool $choose_format = false;
    public array $home_matrix = [];
    public array $visit_matrix = [];
    public array $rounds = [1 => 'First', 6 => 'Second', 11 => 'Last'];
    public bool $can_update_players = true;

    public function mount(): void
    {
        $this->event->loadMissing('games', 'team_1.players', 'team_2.players');
        $this->home_players = $this->event->team_1->players->sortBy('name');
        $this->visit_players = $this->event->team_2->players->sortBy('name');
        if ($this->event->games()->count() > 0) {
            if ($this->event->games()->whereNotNull('win')->count()) {
                $this->can_update_players = false;
            }
            $this->format = $this->event->games()
                ->orderBy('position')
                ->first()
                ->schedule
                ->format;
            $this->recreateMatrix();
        } else {
            $format = Format::all();
            if ($format->count() === 1) {
                $this->formatChosen($format->first()->id);
                $this->recreateMatrix();
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
        $this->dispatch('format-chosen');
    }

    #[On('score-given')]
    public function scoreGiven($game_id): void
    {
        $game = Game::find($game_id);
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
                ['home', !$game->home]]
        )->update(['win' => $score_is_true ? null : false]);

        //$this->event = $this->event->refresh()->load('games', 'team_1.players', 'team_2.players');

        // check if this is the first score being given, if so, lock the players order
        if ($this->event->games()->whereNotNull('win')->count()) {
            $this->can_update_players = false;

        }

        // finally, update the day score in the event
        $this->event->update(['score1' => $this->getEventScore(true), 'score2' => $this->getEventScore(false)]);

        $this->dispatch('score-updated');
    }

    private function getEventScore(bool $home): int
    {
        return $this->event->games()
            ->select(['team_id', 'position'])
            ->where('home', $home)
            ->distinct()
            ->addSelect('win')
            ->where('win', true)
            ->get()
            ->count();
    }

    public function getScoreStatus($event_id, int $position, bool $home): bool
    {
        return Game::where([
                ['event_id', $event_id],
                ['position', $position],
                ['home', $home]]
        )->first()->win;
    }

    #[On('player-selected')]
    public function playerSelected(int $player_id, int $position, string $place): void
    {
        if ($player = Player::find($player_id)) {
            $team = $player->team;
            if ($place === 'home') {
                $this->home_matrix[$position] = $player;
            } else {
                $this->visit_matrix[$position] = $player;
            }
        } else {
            if ($place === 'home') {
                unset($this->home_matrix[$position]);
                $team = $this->event->team_1;
            } else {
                unset($this->visit_matrix[$position]);
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

        (new Game)->where([
            ['event_id', $this->event->id],
            ['team_id', $team->id],
            ['home', $place === 'home',]
        ])->whereIn('position', array_diff($schedules->pluck('position')->toArray(), [5, 10, 15]))
            ->delete();

        foreach ($schedules as $schedule) {
            if ($player) {
                (new Game)->create([
                    'schedule_id' => $schedule->id,
                    'event_id' => $this->event->id,
                    'team_id' => $player->team->id,
                    'player_id' => $player_id,
                    'position' => $schedule->position,
                    'home' => $place === 'home',
                ]);
            }
        }
        $this->dispatch('player-updated-' . $place);
    }

    #[On('player-changed')]
    public function playerChanged(int $player_id, int $game_id): void
    {
        Game::whereId($game_id)->update(['player_id' => $player_id]);
    }

    #[On('schedule-reset')]
    public function scheduleReset(bool $home): void
    {
        $this->event->games()->where('home', $home)->delete();
        $home ? $this->home_matrix = [] : $this->visit_matrix = [];
        $this->recreateMatrix();
        $this->dispatch('player-updated-' . $home ? 'home' : 'visit');
    }

    private function recreateMatrix(): void
    {
        foreach ($this->event->games()->with('player.user')->whereBetween('position', [1, 4])->get() as $game) {
            $game->home
                ? $this->home_matrix[$game->position] = $game->player
                : $this->visit_matrix[$game->position] = $game->player;
        }
        if ($reserves = $this->home_players->diff($this->home_matrix)) {
            $i = 5;
            foreach ($reserves as $reserve) {
                $this->event->team_1->players->contains(fn($r) => $r === $reserve)
                    ? $this->home_matrix[$i] = $reserve
                    : $this->visit_matrix[$i] = $reserve;
                $i++;
            }
        }
    }
}

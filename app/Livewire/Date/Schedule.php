<?php

namespace App\Livewire\Date;

use App\Models\Event;
use App\Models\Format;
use App\Models\Game;
use App\Models\Season;
use App\Services\ScheduleManager;
use Illuminate\Support\Collection as Settings;
use Illuminate\Support\Facades\Context;
use Livewire\Attributes\On;
use Livewire\Component;

class Schedule extends Component
{
    public Event $event;
    public ?Format $format = null;
    public Settings $switches;
    public Season $season;

    public function mount(): void
    {
        $this->season = Season::query()->find(Context::getHidden('season_id'));
        $this->event->loadMissing('games', 'team_1.players', 'team_2.players');
        $this->format = (new ScheduleManager($this->event))->setFormat();
        $this->switches = $this->collectSwitches();//$this->event->games()->delete();
    }

    protected function collectSwitches(): Settings
    {
        return collect([
            'confirmed' => $this->event->confirmed,
            'canUpdatePlayers' => $this->countGames(),
            'chooseFormat' => is_null($this->format),
            'rounds' => [1 => 'First', 6 => 'Second', 11 => 'Last'],
            'games' => null,
        ]);
    }

    private function countGames(): bool
    {
        if (auth()->check() && auth()->user()->can('update', $this->event)) {
            return $this->event->games()
                    ->whereBetween('position', [1, 15])
                    ->whereNotNull('win')
                    ->count() === 0;
        }
        return false;
    }

    #[On('update-settings')]
    public function updateSettings(?string $specific, ?array $games = null): void
    {
        switch ($specific) {
            case 'choose-format':
                $this->format = (new ScheduleManager($this->event))->setFormat();
                $this->switches->put('choose_format', true);
                break;

            case 'can-update-players':
                $this->checkIfPlayersCanBeUpdated();
                break;

                // the games come from Ably in array form, needs to be translated
                // to a Game modal so we can easily filter on them
            case 'score-set':
                $this->checkIfPlayersCanBeUpdated();
                $collection = collect();
                if ($games) {
                    foreach ($games as $game) {
                        $collection->push(new Game($game));
                    }
                }
                $this->switches->put('games', $collection);
                break;

            case 'confirmed':
                $this->switches->put('confirmed', true);
                break;

            default:
                $this->format = (new ScheduleManager($this->event))->setFormat();
                $this->checkIfPlayersCanBeUpdated();
        }
    }

    #[On('format-chosen')]
    public function formatChosen(int $id): void
    {
        $this->format = Format::query()->findOrFail($id);
        $this->switches->put('chooseFormat', false);
        (new ScheduleManager($this->event))->checkThirdGame($this->format);
    }

    protected function checkIfPlayersCanBeUpdated(): void
    {
        $this->switches->put(
            'canUpdatePlayers',
            $this->countGames()
        );
    }

    #[On('format-set')]
    public function formatIsSet(): void
    {
        //$this->format = Format::query()->findOrFail($id);
        $this->switches->put('chooseFormat', false);
        //$this->event = (new ScheduleManager($this->event))->checkThirdGame($this->format);
        $this->render();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.date.schedule')->with(['switches' => $this->switches]);
    }

    #[On('echo:live-score,ScoreEvent')]
    public function updateLiveScores($response): void
    {
        if ($this->event->id === $response['event_id'] && app()->environment($response['environment'])) {
            $this->dispatch('refresh-list');
        }
    }
}

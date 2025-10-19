<?php

namespace App\Livewire;

use App\Models\Date;
use App\Models\Event;
use App\Skeletons\ScoreSkeleton;
use App\Traits\CalendarTrait;
use App\Traits\ResultsTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Context;
use Livewire\Attributes\On;
use Livewire\Component;

class Score extends Component
{
    use CalendarTrait;
    use ResultsTrait;
    use WithSetMyTeam;

    public array $scores;
    public int $i = 1;
    public int $played_weeks = 0;
    public ?Date $date;
    public ?int $score_id = null;
    public bool $show_full_table = false;
    public bool $isAndroid = false;

    public function mount(): void
    {
        $this->date = $this->getLastWeek();
        $this->scores = $this->getResults();
    }

    public function render(): View
    {
        return view('livewire.score')->with(['scores' => $this->scores]);
    }

    public function placeholder(): string
    {
        return ScoreSkeleton::html();
    }

    public function toggleShowFullTable(): void
    {
        $this->show_full_table = !$this->show_full_table;
    }

    /**
     * Determine the last played week
     */
    private function getLastWeek(): ?Date
    {
        $dates = Date::query()->whereSeasonId(Context::getHidden('season_id'))
            ->has(
                'events',
                '>',
                0,
                'and',
                fn (Builder $q) => $q->whereNotNull(['score1', 'score2'])
            )
            ->with('events')
            ->orderBy('dates.date')
            ->get();

        if ($dates->first()->events()->count() === 0) {
            return $dates->first();
        }

        $this->played_weeks = $dates->count();

        return $dates->last();
    }

    #[On('echo:live-score,ScoreEvent')]
    public function updateLiveScores(array $response): void
    {
        if (app()->environment() === $response['environment']) {
            $event = Event::query()->find($response['event_id']);
            if ($event->date->season_id === Context::getHidden('season_id')) {
                $this->scores = $this->getResults();
                $this->score_id = $event->id;
            }
        }
    }
}

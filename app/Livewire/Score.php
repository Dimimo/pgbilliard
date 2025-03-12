<?php

namespace App\Livewire;

use App\Models\Date;
use App\Models\Event;
use App\Traits\CalendarTrait;
use App\Traits\ResultsTrait;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Score extends Component
{
    use CalendarTrait;
    use ResultsTrait;
    use WithCurrentCycle;
    use WithSetMyTeam;
    use WithHasAccess;

    public array $scores;
    public int $i = 1;
    public int $week = 0;
    public Date $date;
    public ?int $score_id = null;
    public $show_full_table = false;

    public function mount(): void
    {
        $this->scores = $this->getResults();
        $this->date = $this->getLastWeek();
    }

    public function render(): View
    {
        return view('livewire.score');
    }

    public function toggleShowFullTable(): void
    {
        $this->show_full_table = !$this->show_full_table;
    }

    /**
     * Determine the last played week
     */
    private function getLastWeek(): Date
    {
        $dates = $this->getCalendar();
        $returnDate = null;

        /** @var Date $first */
        $first = $dates->first();
        if ($first->events()->count() === 0) {
            return $first;
        }
        foreach ($dates as $date) {
            if (count($date->events) > 0 && $date->events[0]->score1 !== null) {
                $returnDate = $date;
                $this->week++;
            }
        }

        return $returnDate;
    }

    #[On('echo:live-score,ScoreEvent')]
    public function updateLiveScores(array $response): void
    {
        $event = Event::find($response['event']['id']);
        if ($event->date->season->cycle === $this->season->cycle) {
            $this->scores = $this->getResults();
        }
    }
}

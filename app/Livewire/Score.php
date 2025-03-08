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
    public int $week;
    public Date $date;
    public ?int $score_id = null;
    public $show_full_table = false;

    public function mount(): void
    {
        $this->scores = $this->getResults();
        $this->week = $this->getLastWeek();
        $this->date = $this->getLastWeek(true);
    }

    public function updatedWithSetMyTeam(): void
    {
        $this->scores = $this->getResults();
    }

    public function toggleShowFullTable(): void
    {
        $this->show_full_table = ! $this->show_full_table;
    }

    public function render(): View
    {
        return view('livewire.score');
    }

    /**
     * Determine the last played week
     */
    private function getLastWeek(bool $return_date = false): int|Date
    {
        $dates = $this->getCalendar();
        $returnDate = null;
        //if this a brand-new cycle, without events, put week played to 0
        /** @var Date $first */
        $first = $dates->first();
        if (! count($first->events)) {
            return 0;
        }
        $week = 0;
        foreach ($dates as $date) {
            if (count($date->events) > 0 && $date->events[0]->score1 !== null) {
                $returnDate = $date;
                $week++;
            }
        }
        if ($return_date) {
            return $returnDate;
        }

        return $week;
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

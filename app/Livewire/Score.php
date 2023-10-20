<?php

namespace App\Livewire;

use App\Models\Date;
use App\Traits\CalendarTrait;
use App\Traits\ResultsTrait;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Score extends Component
{
    use CalendarTrait, ResultsTrait, WithCurrentCycle, WithSetMyTeam;

    public array $scores;

    public int $i = 1;

    public int $week;

    public Date $date;

    public ?int $score_id = null;

    public function mount()
    {
        $this->scores = $this->getResults();
        $this->week = $this->getLastWeek();
        $this->date = $this->getLastWeek(true);
    }

    public function updatedWithSetMyTeam()
    {
        $this->scores = $this->getResults();
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
}

<?php

namespace App\Livewire\Admin\Calendar;

use App\Livewire\Forms\DateForm;
use App\Models\Date;
use App\Models\Season;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Shift extends Component
{
    public Season $season;
    public Collection $dates;
    public Collection $mutable_dates;
    public Collection $events;
    public DateForm $form;
    public ?Date $last_played_date = null;

    public function mount(Season $season): void
    {
        $this->season = $season;
        $this->getLastPlayedDate();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.calendar.shift');
    }

    private function getLastPlayedDate(): void
    {
        $this->dates = Date::whereSeasonId($this->season->id)
            ->withCount(['events' => fn($event) => $event->where('confirmed', 1)])
            ->orderBy('date')
            ->get();        $this->mutable_dates = $this->dates->filter(fn($date) => $date->events_count === 0);
        $this->last_played_date = $this->mutable_dates->first();
        $this->form->setDate($this->last_played_date);
    }

    public function changeDate(int $date_id, $diff): void
    {
        $date = Date::find($date_id);
        $new_date = $date->date->addDays($diff);
        $overlaps = $this->dates->filter(fn($exists) => $exists->date == $new_date)->count() === 1;
        if ($overlaps) {
            $this->dispatch('overlaps');
        } else {
            $date->update(['date' => $new_date]);
            $this->getLastPlayedDate();
        }
    }
}

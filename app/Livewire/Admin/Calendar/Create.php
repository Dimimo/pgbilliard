<?php

namespace App\Livewire\Admin\Calendar;

use App\Livewire\Forms\DateForm;
use App\Livewire\Forms\EventForm;
use App\Models\Date;
use App\Models\Event;
use App\Models\Season;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Create extends Component
{
    public Season $season;
    public Collection $dates;
    public Collection $events;
    public EventForm $event;
    public Date $last_date;
    public DateForm $dateForm;
    public Collection $teams;
    public Collection $venues;

    public function mount(Season $season): void
    {
        $this->season = $season;
        $this->getLastEvent();
        $this->teams = Team::whereSeasonId($season->id)->orderBy('name')->get();
        $venue_ids = Team::whereSeasonId($season->id)->get()->unique('venue_id')->pluck('venue_id')->toArray();
        $this->venues = Venue::whereIn('id', $venue_ids)->where('name', '<>', 'BYE')->orderBy('name')->get();
    }

    public function render(): View
    {
        return view('livewire.admin.calendar.create');
    }

    public function updating($name, $value): void
    {
        if ($name === 'event.date_id' && $value) {
            $this->setSelectedDate($value);
        } elseif ($name === 'dateForm.regular') {
            $this->dateForm->regular = $value ? 1 : 0;
            $this->dateForm->update();
            $this->last_date->refresh();
        } elseif ($name === 'dateForm.title') {
            $this->dateForm->title = $value;
            $this->dateForm->update();
            $this->last_date->refresh();
        } elseif ($name === 'event.team1') {
            $team = Team::find($value);
            $this->event->venue_id = $team?->venue_id;
            $this->event->validate();
        } elseif ($name === 'event.team2') {
            $this->event->validate();
        } elseif ($name === 'event.venue_id') {
            $venue = Venue::find($value);
            $this->event->venue_id = $venue?->id;
            $this->event->validate();
        }
    }

    public function selectedDate($date_id): void
    {
        $this->setSelectedDate($date_id);
    }

    private function setSelectedDate($date_id): void
    {
        $this->last_date = Date::find($date_id);
        $this->dateForm->setDate($this->last_date);
        $this->events = $this->last_date->events;
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function save(): void
    {
        $this->event->store();
        $this->dispatch('event-created');
        $this->last_date->refresh();
        $this->dates = Date::whereSeasonId($this->season->id)->with('events')->orderBy('date')->get();
        $this->events = $this->last_date->events;
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function addNextWeek(): void
    {
        // first make sure it is set at the latest day to avoid doubles
        $this->last_date = $this->dates->last();
        // add a week and save it, refresh dates and events
        $next_week = $this->last_date->date->addWeek();
        $this->last_date = Date::create(['season_id' => $this->season->id, 'date' => $next_week, 'regular' => false]);
        $this->dateForm->setDate($this->last_date);
        $this->dates = Date::whereSeasonId($this->season->id)->with('events')->orderBy('date')->get();
        $this->events = $this->last_date->events;
        // prepare the field for the next game
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function removeEvent($event_id): void
    {
        $event = Event::find($event_id);
        $this->authorize('delete', $event);
        $event->delete();
        $this->last_date->refresh();
        $this->events = $this->last_date->events;
    }

    public function removeDate($date_id): void
    {
        $this->last_date = Date::find($date_id);
        $this->authorize('delete', $this->last_date);
        if ($this->last_date->events()->count() == 0) {
            $this->last_date->delete();
            $this->getLastEvent();
        }
    }

    private function getLastEvent(): void
    {
        $this->dates = Date::whereSeasonId($this->season->id)
            ->with('events')
            ->orderBy('date')
            ->get();
        $this->last_date = $this->dates->last();
        $this->dateForm->setDate($this->last_date);
        $this->events = $this->last_date->events;
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function concludeSeason(): void
    {
        // make sure the first playing date games are set to 0-0
        $date_id = $this->dates->first()->id;
        Event::whereDateId($date_id)->update(['score1' => 0, 'score2' => 0]);
        $this->redirect(route('calendar'), navigate: true);
    }

    public function continueToCalendar(): void
    {
        $this->redirect(route('calendar'), navigate: true);
    }

    public function createNewTeam(): void
    {
        $this->redirect(route('admin.teams.create', ['season' => $this->season]));
    }
}

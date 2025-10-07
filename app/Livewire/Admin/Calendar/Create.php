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
use Livewire\Attributes\On;
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
        $this->getLastEventAndPotentiallyDeleteTheSeason();
        $this->getTeams();
        $venue_ids = Team::query()->whereSeasonId($season->id)
            ->get()
            ->unique('venue_id')
            ->pluck('venue_id')
            ->toArray();
        $this->venues = Venue::query()->whereIn('id', $venue_ids)
            ->where('name', '<>', 'BYE')
            ->orderBy('name')
            ->get();
    }

    public function render(): View
    {
        return view('livewire.admin.calendar.create');
    }

    public function updated($name, $value): void
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
            $team = Team::query()->find($value);
            $this->event->venue_id = $team->venue_id;
            $this->event->validate();
        } elseif ($name === 'event.team2') {
            $this->event->validate();
        } elseif ($name === 'event.venue_id') {
            $venue = Venue::query()->find($value);
            $this->event->venue_id = $venue->id;
            $this->event->validate();
            if (Team::query()->find($this->event->team1)->venue_id !== $venue->id) {
                $this->addError('event.venue_id', "Reminder: the selected bar is not that of the Home Team, is it your intention?");
            } else {
                $this->resetErrorBag(['event.venue_id']);
            }
        }
    }

    public function selectedDate($date_id): void
    {
        $this->setSelectedDate($date_id);
    }

    private function setSelectedDate($date_id): void
    {
        $this->last_date = Date::query()->find($date_id);
        $this->dateForm->setDate($this->last_date);
        $this->events = $this->last_date->events;
        $this->event->reset(['venue_id', 'team1', 'team2']);
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function save(): void
    {
        $this->authorize('create', Event::class);
        $this->event->store();
        $this->dispatch('event-created');
        $this->last_date->refresh();
        $this->events = $this->last_date->events;
        $this->event->reset(['venue_id', 'team1', 'team2']);
        $this->dates = Date::query()->whereSeasonId($this->season->id)->with('events')->orderBy('date')->get();
    }

    public function addNextWeek(): void
    {
        $this->authorize('create', Date::class);
        // first make sure it is set at the latest day to avoid doubles
        $this->last_date = $this->dates->last();
        // add a week and save it, refresh dates and events
        $next_week = $this->last_date->date->addWeek();
        $this->last_date = Date::query()->create(['season_id' => $this->season->id, 'date' => $next_week, 'regular' => false]);
        $this->dateForm->setDate($this->last_date);
        $this->dates = Date::query()->whereSeasonId($this->season->id)->with('events')->orderBy('date')->get();
        $this->events = $this->last_date->events;
        $this->event->reset(['venue_id', 'team1', 'team2']);
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function removeEvent($event_id): void
    {
        $event = Event::query()->find($event_id);
        $this->authorize('delete', $event);
        $event->delete();
        $this->last_date->refresh();
        $this->events = $this->last_date->events;
    }

    public function removeDate($date_id): void
    {
        $this->last_date = Date::query()->find($date_id);
        $this->authorize('delete', $this->last_date);
        if ($this->last_date->events()->count() == 0) {
            $this->last_date->delete();
            $this->getLastEventAndPotentiallyDeleteTheSeason();
        }
    }

    public function getLastEventAndPotentiallyDeleteTheSeason(): void
    {
        // check if a season has any dates, if not, just delete the season, teams and players
        if (Date::query()->whereSeasonId($this->season->id)->count() === 0) {
            $this->deleteSeason();
            return;
        }

        $this->dates = Date::query()->whereSeasonId($this->season->id)
            ->with('events')
            ->orderBy('date')
            ->get();
        $this->last_date = $this->dates->last();
        $this->dateForm->setDate($this->last_date);
        $this->events = $this->last_date->events;
        $this->event->reset(['venue_id', 'team1', 'team2']);
        $this->event->setEvent(new Event(['date_id' => $this->last_date->id]));
    }

    public function concludeSeason(): void
    {
        // make sure the first playing date games are set to 0-0
        $date_id = $this->dates->first()->id;
        Event::query()->whereDateId($date_id)->update(['score1' => 0, 'score2' => 0]);
        $this->redirect(route('calendar'), navigate: true);
    }

    #[On('team-added')]
    public function newTeamCreated(): void
    {
        $this->getTeams();
    }

    private function getTeams(): void
    {
        $this->teams = Team::query()->whereSeasonId($this->season->id)->orderBy('name')->get();
    }

    // delete the SEASON as it has no more dates
    private function deleteSeason(): void
    {
        $this->authorize('update', $this->season);
        if ($this->season->teams->count() > 0) {
            foreach ($this->season->teams as $team) {
                $team->players()->delete();
            }
        }
        $this->season->teams()->delete();
        $this->season->dates()->delete();
        $this->authorize('delete', $this->season);
        $this->season->delete();
        session()->forget(['cycle', 'alert', 'number_of_teams', 'players', 'has_bye']);
        session()->flash('status', 'The Season has been deleted');
        $this->redirect(route('admin.seasons.create'));
    }
}

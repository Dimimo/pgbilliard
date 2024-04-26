<?php

namespace App\Livewire;

use App\Models\Date;
use App\Models\Event;
use App\Models\Team;
use App\Models\Venue;
use App\Taps\Cycle;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class NewGame extends Component
{
    public Date $date;

    public Event $event;

    public Collection $dates;

    public array $teams;

    public array $venues;

    protected array $rules = [
        'event.pool_date_id' => 'required',
        'event.team1' => 'required|numeric|gt:0',
        'event.team2' => 'required|numeric|gt:0',
        'event.pool_venue_id' => 'required|numeric|gt:0',
        'event.score1' => 'nullable|numeric|gte:0|lte:15',
        'event.score2' => 'nullable|numeric|gte:0|lte::15',
        'event.remark' => 'nullable|max:500',
    ];

    protected array $messages = [
        'event.pool_date_id.required' => 'Please choose a playing date',
        'event.team1.required' => 'Please choose the Home Team',
        'event.team2.required' => 'Please choose the Visiting Team',
        'event.team1.gt' => 'Please choose the Home Team',
        'event.team2.gt' => 'Please choose the Visiting Team',
        'event.pool_venue_id.required' => 'Please choose a venue',
        'event.pool_venue_id.gt' => 'Please choose a venue',
        'event.score1.numeric' => 'The value is not numeric',
        'event.score1.gte' => 'The value has to be 0 or more',
        'event.score1.lte' => 'The value has to be 15 or less',
        'event.score2.numeric' => 'The value is not numeric',
        'event.score2.gte' => 'The value has to be 0 or more',
        'event.score2.lte' => 'The value has to be 15 or less',
        'event.remark' => 'The remark can\'t be more than 500 chars',
    ];

    public function mount(Date $date, Event $event): void
    {
        $this->date = $date;
        $this->event = $event;
        $this->dates = $this->getDates();
        $this->teams = $this->getTeams();
        $this->venues = $this->getVenues();
    }

    public function render(): View
    {
        return view('pool::livewire.new-game');
    }

    public function updated($name, $value): void
    {
        if ($name === 'event.team1') {
            $team = Team::with('venue')->find($value);
            $this->event->venue_id = $team?->venue->id;
        }
        $this->validateOnly($name);
        if ($name === 'event.team1') {
            $this->validateOnly('event.pool_venue_id');
        }
    }

    public function store(): void
    {
        $this->validate();
        $this->event->exists ? $this->event->update() : $this->event->save();
        $this->event = new Event(['pool_date_id' => $this->date->id]);
        $this->date->refresh();
    }

    private function getDates(): Collection
    {
        return Date::tap(new Cycle())
            ->orderByDesc('date')
            ->get()
            ->pluck('date', 'id')
            ->map(function (Carbon $date) {
                return $date->format('Y-m-d');
            });
    }

    private function getVenues(): array
    {
        return Venue::orderBy('name')
            ->whereIn('id', $this->getVenueIds())
            ->where('name', '<>', 'BYE')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }

    private function getVenueIds(): array
    {
        return Team::tap(new Cycle())
            ->get()
            ->unique('pool_venue_id')
            ->pluck('pool_venue_id')
            ->toArray();
    }

    private function getTeams(): array
    {
        return Team::tap(new Cycle())
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}

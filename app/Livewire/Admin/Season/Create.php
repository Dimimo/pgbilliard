<?php

namespace App\Livewire\Admin\Season;

use App\Models\Date;
use App\Models\Season;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Create extends Component
{
    public Season $season;

    public string $cycle;

    public int $number_of_teams;

    public string $day_of_week;

    public string $starting_date;

    public bool $has_bye;

    public function mount(): void
    {
        $this->season = new Season(['cycle' => Carbon::now()->format('Y/m')]);
        $this->cycle = $this->season->cycle;
        $this->number_of_teams = 6;
        $this->has_bye = false;
        $this->day_of_week = 'Wednesday';
        $this->starting_date = Carbon::now()->next($this->day_of_week)->format('Y-m-d');
        $this->validate($this->getValidation(), $this->getAlerts());
    }

    public function render(): View
    {
        return view('livewire.admin.season.create');
    }

    public function save(): void
    {
        $validated = $this->validate($this->getValidation(), $this->getAlerts());
        $season = Season::create($validated);
        Date::create([
            'season_id' => $season->id,
            'date' => Carbon::createFromFormat('Y-m-d', $this->starting_date),
        ]);
        $this->dispatch('season-created');

        session('alert', "Season $season->cycle is created. Time to create the teams!");
        session('number_of_teams', $this->number_of_teams);
        session('has_bye', $this->has_bye);

        $this->redirect('/admin/teams/create/'.$season->id, navigate: true);
    }

    public function updating($name, $value): void
    {
        if ($name === 'number_of_teams') {
            $this->has_bye = $value % 2 !== 0;
        } elseif ($name === 'day_of_week') {
            $this->starting_date = Carbon::now()->next($this->day_of_week)->format('Y-m-d');
        } elseif ($name === 'cycle') {
            $this->validate($this->getValidation(), $this->getAlerts());
        }
    }

    public function addMonth(): void
    {
        $this->cycle = Carbon::createFromFormat('Y/m', $this->cycle)->addMonth()->format('Y/m');
        $this->validate($this->getValidation(), $this->getAlerts());
    }

    public function subMonth(): void
    {
        $this->cycle = Carbon::createFromFormat('Y/m', $this->cycle)->subMonth()->format('Y/m');
        $this->validate($this->getValidation(), $this->getAlerts());
    }

    public function addWeek(): void
    {
        $this->starting_date = Carbon::createFromFormat('Y-m-d', $this->starting_date)->addWeek()->format('Y-m-d');
    }

    public function subWeek(): void
    {
        $this->starting_date = Carbon::createFromFormat('Y-m-d', $this->starting_date)->subWeek()->format('Y-m-d');
    }

    private function getValidation(): array
    {
        return ['cycle' => [
            'date_format:Y/m',
            'unique:seasons,cycle',
        ],
        ];
    }

    private function getAlerts(): array
    {
        return [
            'cycle.date_format' => 'The new Season has to have the format yyyy/mm',
            'cycle.unique' => 'This Season already exists, consider the next month',
        ];
    }
}

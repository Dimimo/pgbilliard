<?php

namespace App\Livewire\Admin\Season;

use App\Constants;
use App\Models\Date;
use App\Models\Season;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Create extends Component
{
    public Season $season;
    public string $cycle;
    public int $number_of_teams = 6;
    public int $players;
    public string $day_of_week;
    public string $starting_date;
    public bool $has_bye = false;

    public function mount(): void
    {
        $this->season = new Season(['cycle' => Carbon::now()->appTimezone()->format('Y/m')]);
        $this->cycle = $this->season->cycle;
        $this->day_of_week = Constants::STARTING_DAY;
        $this->players = Constants::MAX_TEAM_PLAYERS;
        $this->starting_date = Carbon::now()
            ->appTimezone()
            ->next($this->day_of_week)
            ->format('Y-m-d');
        $this->validate($this->getValidation(), $this->getAlerts());
    }

    public function render(): View
    {
        return view('livewire.admin.season.create');
    }

    public function save(): void
    {
        $validated = $this->validate($this->getValidation(), $this->getAlerts());
        $season = Season::query()->create($validated);
        Date::query()->create([
            'season_id' => $season->id,
            'date' => Carbon::createFromFormat('Y-m-d', $this->starting_date),
        ]);
        $this->dispatch('season-created');
        session(['alert' => "Season $season->cycle is created. Time to create the teams!"]);
        session(['number_of_teams' => $this->number_of_teams]);
        session(['players' => $this->players]);
        session(['has_bye' => $this->has_bye]);
        $this->redirect(route('admin.season.update', ['season' => $season]), navigate: true);
    }

    public function updating($name, $value): void
    {
        if ($name === 'number_of_teams') {
            $this->number_of_teams = $value;
            $this->has_bye = $value % 2 !== 0;
        } elseif ($name === 'day_of_week') {
            $this->day_of_week = $value;
            $this->starting_date = Carbon::createFromFormat('Y-m-d', $this->starting_date)
                ->appTimezone()
                ->firstOfMonth($this->getWeekDay())
                ->format('Y-m-d');
        } elseif ($name === 'cycle') {
            $this->validate($this->getValidation(), $this->getAlerts());
        }
    }

    public function addMonth(): void
    {
        $this->cycle = Carbon::createFromFormat('Y/m', $this->cycle)
            ->appTimezone()
            ->addMonth()
            ->format('Y/m');

        $this->starting_date = Carbon::createFromFormat('Y-m-d', $this->starting_date)
            ->appTimezone()->addMonth()
            ->firstOfMonth($this->getWeekDay())
            ->format('Y-m-d');

        $this->validate($this->getValidation(), $this->getAlerts());
    }

    public function subMonth(): void
    {
        $this->cycle = Carbon::createFromFormat('Y/m', $this->cycle)
            ->appTimezone()
            ->subMonth()
            ->format('Y/m');

        $this->subMonthAndCheck();
        $this->validate($this->getValidation(), $this->getAlerts());
    }

    public function addWeek(): void
    {
        $this->starting_date = Carbon::createFromFormat('Y-m-d', $this->starting_date)
            ->appTimezone()
            ->addWeek()
            ->format('Y-m-d');
    }

    public function subWeek(): void
    {
        $this->starting_date = Carbon::createFromFormat('Y-m-d', $this->starting_date)
            ->appTimezone()
            ->subWeek()
            ->format('Y-m-d');
    }

    private function getValidation(): array
    {
        return [
            'cycle' => [
                'date_format:Y/m',
                'unique:seasons,cycle',
            ],
            'players' => [
                'required',
                'int',
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

    //Checks if the subtracted date is younger than the current time
    //as it first starts with the first weekday day of the month it is possible
    private function subMonthAndCheck(): void
    {
        $this->starting_date = Carbon::createFromFormat('Y-m-d', $this->starting_date)
            ->appTimezone()
            ->subMonth()
            ->firstOfMonth($this->getWeekDay())
            ->format('Y-m-d');

        if (Carbon::createFromFormat('Y-m-d', $this->starting_date)->isSameMonth(Carbon::now())) {
            $this->starting_date = Carbon::now()->appTimezone()->next($this->day_of_week)->format('Y-m-d');
        }
    }

    //Get the ISO number of the day of week
    private function getWeekDay(): int
    {
        $weekdays = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];
        $weekdays = array_flip($weekdays);

        return $weekdays[$this->day_of_week];
    }
}

<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Format;
use App\Models\Schedule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public Format $format;
    public ?Schedule $schedule;
    public $table;
    #[Validate(['required', 'min:4', 'max:20', 'unique:formats,name'])]
    public ?string $name = null;

    public array $rounds = [1 => 'First', 6 => 'Second', 11 => 'Last'];

    public function mount(?Format $format): void
    {
        if (!$format->exists) {
            $this->format = new Format();
        }
        $this->name = $this->format?->name;
        $this->table = $this->format?->schedules;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.schedule.create');
    }

    // when a player is chosen from the dropdown, this method is called
    // it either updates an existing field or creates a new entry
    // if the player is 0, delete the entry
    public function player(int $player, int $position, bool $home = true): void
    {
        if ($player === 0) {
            $this->format->schedules()->where([['position', $position], ['home', $home]])->delete();
        } else {
            $this->schedule = $this->format->schedules()->where([['player', $player], ['position', $position], ['home', $home]])->first();
            $exists = !is_null($this->schedule);
            $exists
                ? $this->schedule->update(['player' => $player, 'position' => $position, 'home' => $home])
                : $this->schedule = $this->format->schedules()->create(['player' => $player, 'position' => $position, 'home' => $home]);
        }
        $this->table = $this->format?->schedules;
    }

    public function save(): void
    {
        $this->validateOnly('name', ['name' => ['min:4', 'max:20']]);
        $this->format->exists
            ? $this->format->update(['name' => $this->name])
            : $this->format = auth()->user()->formats()->create(['name' => $this->name]);
    }
}

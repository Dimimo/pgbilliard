<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Format;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public Format $format;
    public Collection $table;
    #[Validate(['required', 'min:4', 'max:20', 'unique:formats,name'])]
    public ?string $name = null;
    #[Validate(['nullable', 'max:256'])]
    public ?string $details = null;
    public bool $request_format_update = false;
    public array $rounds = [1 => 'First', 6 => 'Second', 11 => 'Last'];

    public function mount(?Format $format): void
    {
        if (!$format->exists) {
            $this->format = new Format();
            $this->request_format_update = true;
        } else {
            $this->name = $this->format->name;
            $this->details = $this->format->details;
            $this->table = $this->format->schedules;
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.schedule.create');
    }

    public function requestFormatUpdate(): void
    {
        $this->request_format_update = true;
    }

    // when a player is chosen from the dropdown, this method is called
    // it either updates an existing field or creates a new entry
    // if the player is 0, delete the entry
    public function player(int $player, int $position, bool $home = true): void
    {
        if ($player === 0) {
            $this->format->schedules()->where([['position', $position], ['home', $home]])->delete();
        } else {
            $schedule = $this->format
                ->schedules()
                ->where([
                    ['player', $player],
                    ['position', $position],
                    ['home', $home]
                ])->first();

            $exists = !is_null($schedule);
            $exists
                ? $schedule->update(['player' => $player, 'position' => $position, 'home' => $home])
                : $this->format->schedules()->create(['player' => $player, 'position' => $position, 'home' => $home]);
        }
        $this->checkThirdDouble();
        $this->table = $this->format->schedules;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'min:4', 'max:20'],
            'details' => ['nullable', 'max:255'],
        ]);
        $this->format->exists
            ? $this->format->update($validated)
            : $this->format = auth()->user()->formats()->create($validated);

        if ($this->request_format_update === true) {
            $this->request_format_update = false;
            $this->dispatch('format-updated');
        } else {
            // redirect (reloads) to this page in case a new input was created
            $this->redirect(route('admin.schedule.update', ['format' => $this->format->id]), navigate: true);
        }
    }

    private function checkThirdDouble(): void
    {
        if ($this->format->schedules()->wherePosition(15)->count() === 0) {
            $this->insertLastDouble(true);
            $this->insertLastDouble(false);
        }
    }

    private function insertLastDouble(bool $home): void
    {
        $values = ['format_id' => $this->format->id, 'position' => 15, 'player' => 0, 'home' => $home];
        $this->format->schedules()->insert([$values, $values]);
    }
}

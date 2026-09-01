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
    public int $players = 4;

    public function mount(?Format $format): void
    {
        if (!$format->exists) {
            $this->format = new Format();
            $this->table = new Collection();
            $this->request_format_update = true;
        } else {
            $this->name = $this->format->name;
            $this->details = $this->format->details;
            $this->players = $this->format->players ?? 4;
            $this->ensureScheduleSlots();
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

    public function updatedPlayers($value): void
    {
        $this->players = $this->format->players = $value;
        $this->format->update();
    }

    public function player(int $scheduleId, int $player): void
    {
        if ($player < 0 || $player > $this->players) {
            $this->addError('table', 'The selected player position is invalid.');

            return;
        }

        $this->format->schedules()->findOrFail($scheduleId)->update(['player' => $player]);
        $this->ensureScheduleSlots();
    }

    private function ensureScheduleSlots(): void
    {
        $schedules = $this->format->schedules()->get();
        $missingSlots = [];

        foreach (range(1, 15) as $position) {
            foreach ([true, false] as $home) {
                $existingSlots = $schedules
                    ->where('position', $position)
                    ->where('home', $home)
                    ->count();
                $requiredSlots = $position % 5 === 0 ? 2 : 1;

                for ($slot = $existingSlots; $slot < $requiredSlots; $slot++) {
                    $missingSlots[] = [
                        'position' => $position,
                        'player' => 0,
                        'home' => $home,
                    ];
                }
            }
        }

        if ($missingSlots !== []) {
            $this->format->schedules()->createMany($missingSlots);
        }

        $this->table = $this->format
            ->schedules()
            ->orderBy('position')
            ->orderByDesc('home')
            ->orderBy('id')
            ->get();
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'min:4', 'max:20'],
            'details' => ['nullable', 'max:255'],
            'players' => ['int', 'min:2', 'max:6'],
        ]);
        $this->format->exists
            ? $this->format->update($validated)
            : ($this->format = auth()->user()->formats()->create($validated));
        $this->ensureScheduleSlots();

        if ($this->request_format_update === true) {
            $this->request_format_update = false;
            $this->dispatch('format-updated');
        } else {
            // redirect (reloads) to this page in case a new input was created
            $this->redirect(
                route('admin.schedule.update', ['format' => $this->format->id]),
                navigate: true,
            );
        }
    }
}

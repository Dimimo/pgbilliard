<?php

namespace App\Livewire;

use App\Models\Event;
use App\Traits\CalendarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Calendar extends Component
{
    use CalendarTrait;
    use WithSetMyTeam;

    public Collection $dates;

    public function mount(): void
    {
        $this->dates = $this->getCalendar();
    }

    public function updatedWithSetMyTeam(): void
    {
        $this->dates = $this->getCalendar();
    }

    public function render(): View
    {
        return view('livewire.calendar');
    }

    #[On('echo:live-score,ScoreEvent')]
    public function updateLiveScores(array $response): void
    {
        $event = Event::query()->find($response['event']['id']);
        if ($event->date->season->cycle === session('cycle')) {
            $this->dates = $this->getCalendar();
        }
    }
}

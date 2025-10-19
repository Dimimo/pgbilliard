<?php

namespace App\Livewire\Date;

use App\Models\Event;
use App\Models\Format;
use Illuminate\Support\Collection as Settings;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ScheduleFormatChooser extends Component
{
    public Event $event;
    #[Reactive]
    public Settings $switches;
    #[Reactive]
    public ?Format $format = null;

    public function mount(Event $event, Settings $switches): void
    {
        $this->event = $event;
        $this->switches = $switches;

        if (is_null($this->format)) {
            $formats = Format::all();
            if ($formats->count() === 1) {
                $id = $formats->first()->id;
                $this->dispatch('format-chosen', id: $id)->to(Schedule::class);
            } elseif (!$this->event->games()->count()) {
                $this->dispatch('update-settings', specific: 'choose-format')->to(Schedule::class);
            }
        }

    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.date.schedule-format-chooser')->with(['switches' => $this->switches]);
    }

    #[On('echo:live-score,ScoreEvent')]
    public function checkForExternalUpdates(): void
    {
        $this->dispatch('update-settings', specific: 'can-update-players')->to(Schedule::class);
        $this->render();
    }
}

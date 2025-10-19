<?php

namespace App\Livewire\Date;

use App\Models\Event;
use App\Services\LiveScoreUpdater;
use Livewire\Attributes\On;
use Livewire\Component;

class ScheduleConfirm extends Component
{
    use ConsolidateTrait;

    public Event $event;

    public function mount(Event $event): void
    {
        $this->event = (new LiveScoreUpdater($event))->getEventScores();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.date.schedule-confirm');
    }

    #[On('echo:live-score,ScoreEvent')]
    public function updateLiveScores($response): void
    {
        if ($this->event->id === $response['event_id'] && app()->environment() === $response['environment']) {
            $this->event = (new LiveScoreUpdater($this->event))->getEventScores();
            $this->render();
        }
    }

    #[On('refresh-list')]
    public function scoreUpdated(): void
    {
        $this->event = (new LiveScoreUpdater($this->event))->getEventScores();
        $this->render();
    }
}

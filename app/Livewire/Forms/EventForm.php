<?php

namespace App\Livewire\Forms;

use App\Models\Event;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventForm extends Form
{
    public Event $event;

    #[Validate('integer', message: 'Choose a date')]
    public int $date_id;

    #[Validate('integer', message: 'Choose a venue')]
    public ?int $venue_id;

    #[Validate('integer', message: 'Choose the home team')]
    public ?int $team1;

    #[Validate('integer', message: 'Choose the visiting team')]
    public ?int $team2;

    #[Validate([
        'nullable',
        'integer',
        'between:0, 15',
    ], message: [
        'score1.integer' => 'The score is not numeric',
        'score1.between' => 'The score is not between 0 and 15',
    ])]
    public ?int $score1;

    #[Validate([
        'nullable',
        'integer',
        'between:0, 15',
    ], message: [
        'score2.integer' => 'The score is not numeric',
        'score2.between' => 'The score is not between 0 and 15',
    ])]
    public ?int $score2;

    #[Validate('nullable|max:100')]
    public ?string $remark;

    public function setEvent(Event $event): void
    {
        $this->event = $event;
        $this->date_id = $event->date_id;
        $this->venue_id = $event->venue_id;
        $this->team1 = $event->team1;
        $this->team2 = $event->team2;
        $this->score1 = $event->score1;
        $this->score2 = $event->score2;
        $this->remark = $event->remark;
    }

    public function store(): void
    {
        $this->event = Event::query()->create($this->validate());
    }

    public function update(): void
    {
        $this->validate();
        $this->event->update($this->only(['score1', 'score2']));
        $this->event->refresh();
    }
}

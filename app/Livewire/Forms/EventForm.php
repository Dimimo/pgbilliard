<?php

namespace App\Livewire\Forms;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventForm extends Form
{
    public Event $event;
    #[Validate]
    public int $date_id;
    #[Validate]
    public ?int $venue_id;
    #[Validate]
    public ?int $team1;
    #[Validate]
    public ?int $team2;
    #[Validate]
    public ?int $score1 = null;
    #[Validate]
    public ?int $score2 = null;
    #[Validate]
    public bool $confirmed;
    #[Validate]
    public ?string $remark = null;

    public function rules(): array
    {
        return (new EventRequest())->rules();
    }

    public function messages(): array
    {
        return (new EventRequest())->messages();
    }

    public function setEvent(Event $event): void
    {
        $this->event = $event;
        $this->fill($this->event);
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

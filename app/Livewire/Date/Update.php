<?php

namespace App\Livewire\Date;

use App\Livewire\Forms\EventForm;
use App\Models\Date;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Update extends Component
{
    public Date $date;

    public EventForm $eventForm;

    protected $rules = [
        'date.events.*.id' => 'integer',
        'date.events.*.score1' => 'between:0,15',
        'date.events.*.score2' => 'between:0,15',
    ];

    public function mount(Date $date)
    {
        $this->date = $date;
    }

    public function render(): View
    {
        return view('livewire.date.update');
    }

    public function updated()
    {
        $this->all()['date']->events->each(function (Event $event) {
            $this->eventForm->setEvent($event);
            $this->eventForm->update();
            $this->date->refresh();
        });
        $this->dispatch('scores-updated');
    }
}

<?php

namespace App\Livewire\Admin\Venues;

use App\Livewire\Forms\VenueForm;
use App\Livewire\WithUsersSelect;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    use WithUsersSelect;

    public VenueForm $venue_form;

    public function mount(Venue $venue): void
    {
        $this->venue_form->setVenue($venue);
    }

    public function render(): View
    {
        return view('livewire.admin.venue');
    }

    public function updated($name, $value): void
    {
        if ($name == 'venue_form.user_id') {
            $this->venue_form->show_name = ! $value;
        }
    }

    public function save(): void
    {
        $this->venue_form->create();
        session()->flash('status', "The venue {$this->venue_form->venue->name} has been created");
        $this->redirect('/venues/show/'.$this->venue_form->venue->id, navigate: true);
    }
}

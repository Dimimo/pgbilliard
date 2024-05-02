<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\VenueForm;
use App\Livewire\WithUsersSelect;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Venue extends Component
{
    use WithUsersSelect;

    public VenueForm $venue_form;

    public function mount(\App\Models\Venue $venue): void
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
        $this->venue_form->update();
        $this->dispatch('venue-updated');
        session()->flash('status', "The venue {$this->venue_form->name} is successfully updated.");
        $this->redirect(route('teams.index'), navigate: true);
    }
}

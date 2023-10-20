<?php

namespace App\Livewire\Team;

use App\Livewire\Forms\TeamForm;
use App\Models\Team;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Edit extends Component
{
    public TeamForm $team_form;

    public Collection $venues;

    public function mount(Team $team)
    {
        $this->team_form->setTeam($team);
        $this->venues = Venue::where('name', '<>', 'BYE')->get();
    }

    public function render(): View
    {
        return view('livewire.team.edit');
    }

    public function team_save()
    {
        $this->team_form->update();
        $this->dispatch('team-updated');
    }

    public function updatedTeamFormVenueId(int $value)
    {
        $this->team_form->venue_id = $value;
        $this->team_form->update();
    }
}

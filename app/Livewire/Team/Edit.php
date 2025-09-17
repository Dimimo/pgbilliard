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

    public function mount(Team $team): void
    {
        $this->team_form->setTeam($team);
        $this->venues = Venue::query()->where('name', '<>', 'BYE')->get();
    }

    public function render(): View
    {
        return view('livewire.team.edit');
    }

    public function create(): void
    {
        $this->authorize('update', $this->team_form->team);
        $this->team_form->update();
        $this->dispatch('team-updated');
    }

    public function updatedTeamFormVenueId(int $value): void
    {
        $this->team_form->venue_id = $value;
        $this->team_form->update();
    }
}

<?php

namespace App\Livewire\Admin\Teams;

use App\Livewire\Forms\TeamForm;
use App\Livewire\WithTeamOrdering;
use App\Models\Season;
use App\Models\Team;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Update extends Component
{
    use WithTeamOrdering;

    public TeamForm $form;
    public Season $season;

    public function mount(Team $team): void
    {
        $this->form->setTeam($team);
        $this->season = $team->season;
    }

    public function render(): View
    {
        return view('livewire.admin.teams.update');
    }

    public function changeTeamVenue(int $venue_id): void
    {
        $this->form->venue_id = $venue_id;
        $this->form->checkAndSetValues('form.venue_id', $venue_id);
        $this->dispatch('teams-updated');
    }

    public function changeTeamCaptain(int $captain_id): void
    {
        $this->form->captain_id = $captain_id;
        $this->form->checkAndSetValues('form.captain_id', $captain_id);
        $this->dispatch('teams-updated');
    }

    public function updating($name, $value): void
    {
        $this->form->checkAndSetValues($name, $value);
        $this->dispatch('teams-updated');
    }
}

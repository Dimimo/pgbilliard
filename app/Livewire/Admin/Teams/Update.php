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

    public function updating($name, $value): void
    {
        $this->form->checkAndSetValues($name, $value);
        $this->dispatch('teams-updated');
    }
}

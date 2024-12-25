<?php

namespace App\Livewire\Admin\Teams;

use App\Livewire\Forms\TeamForm;
use App\Livewire\WithTeamOrdering;
use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Update extends Component
{
    use WithTeamOrdering;

    public TeamForm $form;

    public Collection $users;

    public Collection $venues;

    public function mount(Team $team): void
    {
        $this->form->setTeam($team);
        $this->users = User::orderBy('name')->get(['id', 'name']);
        $this->venues = Venue::orderBy('name')->get(['id', 'name']);
    }

    public function render(): View
    {
        return view('livewire.admin.teams.update');
    }

    public function updating($name, $value): void
    {
        if ($name === 'form.name') {
            $this->validateOnly('form.name');
            $this->form->team->update(['name' => $value]);
        } elseif ($name === 'form.venue_id') {
            $this->validateOnly('form.venue_id');
            $this->form->team->update(['venue_id' => $value]);
        } elseif ($name === 'form.captain_id') {
            // selecting a new captain is different, first delete the existing captain, then add the new one
            $this->form->team->players()->whereCaptain(true)->delete();
            $this->form->team->players()->create(['user_id' => $value, 'captain' => true]);
        }
        $this->dispatch('teams-updated');
    }
}

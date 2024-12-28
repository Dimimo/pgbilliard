<?php

namespace App\Livewire\Admin\Teams;

use App\Livewire\Forms\TeamForm;
use App\Livewire\WithCurrentCycle;
use App\Models\Team;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use WithCurrentCycle;

    public TeamForm $form;

    public function mount(): void
    {
        $this->cycle = $this->getCurrentCycle();
        $this->season = $this->getCycle();
        $this->form->setTeam(new Team(['season_id' => $this->season->id]));
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.teams.create');
    }

    public static function modalMaxWidthClass(): string
    {
        return 'max-w-xl md:max-w-2xl';
    }

    public function updating($name, $value): void
    {
        $this->form->checkAndSetValues($name, $value);
    }

    public function save(): void
    {
        $this->authorize('create', $this->form->team);
        $team = $this->form->store();
        $this->dispatch('team-added', $team->id);
        $this->closeModal();
        ;
    }
}

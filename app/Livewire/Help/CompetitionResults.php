<?php

namespace App\Livewire\Help;

use LivewireUI\Modal\ModalComponent;

class CompetitionResults extends ModalComponent
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.help.competition-results');
    }
}

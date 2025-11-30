<?php

namespace App\Livewire\Help;

use LivewireUI\Modal\ModalComponent;

class Teams extends ModalComponent
{
    public string $help = "Teams";

    public function render(): \Illuminate\View\View
    {
        return view('livewire.help.teams');
    }

    #[\Override]
    public static function modalMaxWidthClass(): string
    {
        return 'max-w-xl md:max-w-2xl';
    }
}

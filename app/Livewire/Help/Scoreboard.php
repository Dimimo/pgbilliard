<?php

namespace App\Livewire\Help;

use LivewireUI\Modal\ModalComponent;

class Scoreboard extends ModalComponent
{
    public string $help = 'Scoreboard';

    #[\Override]
    public static function modalMaxWidthClass(): string
    {
        return 'max-w-xl md:max-w-2xl';
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.help.scoreboard');
    }
}

<?php

namespace App\Livewire\Help;

use LivewireUI\Modal\ModalComponent;

class Scoreboard extends ModalComponent
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.help.scoreboard');
    }

    public static function modalMaxWidthClass(): string
    {
        return 'max-w-xl md:max-w-2xl';
    }
}

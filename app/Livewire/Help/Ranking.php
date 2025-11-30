<?php

namespace App\Livewire\Help;

use LivewireUI\Modal\ModalComponent;

class Ranking extends ModalComponent
{
    public string $help = "Individual Ranking Overview";

    public function render(): \Illuminate\View\View
    {
        return view('livewire.help.ranking');
    }

    #[\Override]
    public static function modalMaxWidthClass(): string
    {
        return 'max-w-xl md:max-w-2xl';
    }
}

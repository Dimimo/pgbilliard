<?php

namespace App\Livewire\Help;

use LivewireUI\Modal\ModalComponent;

class LiveScores extends ModalComponent
{
    public string $help = "live scores and update";

    public function render(): \Illuminate\View\View
    {
        return view('livewire.help.live-scores');
    }

    #[\Override]
    public static function modalMaxWidthClass(): string
    {
        return 'max-w-xl md:max-w-2xl';
    }
}

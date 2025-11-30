<?php

namespace App\Livewire\Help;

use LivewireUI\Modal\ModalComponent;

class Calendar extends ModalComponent
{
    public string $help = 'Calendar';

    public function render(): \Illuminate\View\View
    {
        return view('livewire.help.calendar');
    }

    #[\Override]
    public static function modalMaxWidthClass(): string
    {
        return 'max-w-xl md:max-w-2xl';
    }
}

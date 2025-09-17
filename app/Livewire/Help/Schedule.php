<?php

namespace App\Livewire\Help;

use LivewireUI\Modal\ModalComponent;

class Schedule extends ModalComponent
{
    public string $help = "The Day Schedule";
    public function render(): \Illuminate\View\View
    {
        return view('livewire.help.schedule');
    }

    public static function modalMaxWidthClass(): string
    {
        return 'max-w-xl md:max-w-2xl';
    }
}

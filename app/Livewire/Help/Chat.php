<?php

namespace App\Livewire\Help;

use LivewireUI\Modal\ModalComponent;

class Chat extends ModalComponent
{
    public string $help = "the chat and rooms";

    public function render(): \Illuminate\View\View
    {
        return view('livewire.help.chat');
    }

    public static function modalMaxWidthClass(): string
    {
        return 'max-w-xl md:max-w-2xl';
    }
}

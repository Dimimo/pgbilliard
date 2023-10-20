<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Footer extends Component
{
    use WithHasAccess;

    public function render(): View
    {
        return view('livewire.footer');
    }
}

<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Results extends Component
{
    public function render(): View
    {
        return view('pool::livewire.results');
    }
}

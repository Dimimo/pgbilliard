<?php

namespace App\Livewire\Footer;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Admin extends Component
{
    public function render(): View
    {
        return view('pool::livewire.footer.admin');
    }
}

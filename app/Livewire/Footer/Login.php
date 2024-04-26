<?php

namespace App\Livewire\Footer;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Login extends Component
{
    public function render(): View
    {
        return view('pool::livewire.footer.login');
    }
}

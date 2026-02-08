<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Footer extends Component
{
    public function render(): View
    {
        return view('livewire.footer');
    }

    public function setLocale(string $locale): void
    {
        \App::setLocale($locale);
        session()->put('locale', $locale);
        $this->redirect('/');
    }
}

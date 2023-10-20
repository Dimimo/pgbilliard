<?php

namespace App\Livewire;

use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        //
    }

    public function render()
    {
        return view('pool::livewire.index')
            ->extends('pool::layouts.pool');
    }
}

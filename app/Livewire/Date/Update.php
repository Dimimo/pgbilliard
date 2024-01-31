<?php

namespace App\Livewire\Date;

use App\Models\Date;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Update extends Component
{
    public Date $date;

    public function mount(Date $date)
    {
        $this->date = $date;
    }

    public function render(): View
    {
        return view('livewire.date.update');
    }
}

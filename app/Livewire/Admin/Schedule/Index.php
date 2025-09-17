<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Format;
use Livewire\Component;

class Index extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.schedule.index')->with([
            'formats' => Format::query()->orderBy('name')->withCount('schedules')->get(),
        ]);
    }
}

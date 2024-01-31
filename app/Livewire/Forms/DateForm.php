<?php

namespace App\Livewire\Forms;

use App\Models\Date;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DateForm extends Form
{
    public Date $pool_date;

    #[Validate(['required', 'date'])]
    public Carbon $date;

    #[Validate(['required', 'boolean'])]
    public bool $regular = false;

    #[Validate('nullable')]
    #[Validate('string', message: 'Only string values allowed')]
    #[Validate('max:20', message: 'Max 20 chars')]
    public ?string $title;

    #[Validate(['nullable', 'max:100'])]
    public ?string $remark;

    public function setDate(Date $date)
    {
        $this->pool_date = $date;
        $this->date = $date->date;
        $this->regular = $date->regular;
        $this->title = $date->title;
        $this->remark = $date->remark;
    }

    public function store()
    {
        $this->validate();

        $this->pool_date = Date::create($this->only(['date', 'regular', 'title', 'remark']));
    }

    public function update()
    {
        $validated = $this->validate();
        $this->pool_date->update($validated);
        $this->pool_date->refresh();
    }
}

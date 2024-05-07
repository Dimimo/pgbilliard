<?php

namespace App\Livewire\Forms;

use App\Constants;
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

    #[Validate([
        'nullable',
        'string',
        'max:20',
    ], message: [
        'string' => 'Only string values allowed',
        'max' => 'Max '.Constants::DATE_TITLE.' chars',
    ])]
    public ?string $title;

    #[Validate(['nullable', 'max:100'])]
    public ?string $remark;

    public function setDate(Date $date): void
    {
        $this->pool_date = $date;
        $this->date = $date->date;
        $this->regular = $date->regular;
        $this->title = $date->title;
        $this->remark = $date->remark;
    }

    public function store(): void
    {
        $this->validate();

        $this->pool_date = Date::create($this->only(['date', 'regular', 'title', 'remark']));
    }

    public function update(): void
    {
        $validated = $this->validate();
        $this->pool_date->update($validated);
        $this->pool_date->refresh();
    }
}

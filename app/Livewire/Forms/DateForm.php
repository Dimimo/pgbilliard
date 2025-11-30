<?php

namespace App\Livewire\Forms;

use App\Http\Requests\DateRequest;
use App\Models\Date as PoolDate;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DateForm extends Form
{
    public PoolDate $pool_date;

    #[Validate]
    public Carbon $date;
    #[Validate]
    public int $season_id;
    #[Validate]
    public bool $regular = false;
    #[Validate]
    public ?string $title = null;
    #[Validate]
    public ?string $remark = null;

    public function rules(): array
    {
        return (new DateRequest())->rules();
    }

    public function messages(): array
    {
        return (new DateRequest())->messages();
    }

    public function setDate(PoolDate $pool_date): void
    {
        $this->season_id = $pool_date->season_id;
        $this->pool_date = $pool_date;
        $this->date = $pool_date->date;
        $this->regular = $pool_date->regular;
        $this->title = $pool_date->title;
        $this->remark = $pool_date->remark;
    }

    public function store(): void
    {
        $this->validate();
        $this->pool_date = PoolDate::query()->create($this->only(['season_id', 'date', 'regular', 'title', 'remark']));
    }

    public function update(): void
    {
        $validated = $this->validate();
        $this->pool_date->update($validated);
        $this->pool_date->refresh();
    }
}

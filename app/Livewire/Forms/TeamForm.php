<?php

namespace App\Livewire\Forms;

use App\Constants;
use App\Models\Team;
use Livewire\Attributes\Rule;
use Livewire\Form;

class TeamForm extends Form
{
    public ?Team $team;

    #[Rule(['required', 'min:2', 'max:'.Constants::TEAMCHARS])]
    public string $name;

    #[Rule(['required', 'exists:App\Models\Venue,id'])]
    public int $venue_id;

    #[Rule(['required', 'exists:App\Models\Season,id'])]
    public int $season_id;

    #[Rule(['nullable', 'text'])]
    public ?string $remark;

    public function setTeam(Team $team): void
    {
        $this->team = $team;
        $this->name = $team->name;
        $this->venue_id = $this->team->venue_id;
        $this->season_id = $this->team->season_id;
        $this->remark = $this->team->remark;
    }

    public function store(): void
    {
        $this->validate();
        Team::create($this->only(['name', 'venue_id', 'season_id', 'remark']));
    }

    public function update(): void
    {
        $this->validate();
        $this->team->update($this->all());
        $this->team->refresh();
    }
}

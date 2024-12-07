<?php

namespace App\Livewire\Forms;

use App\Constants;
use App\Models\Team;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TeamForm extends Form
{
    public ?Team $team;

    #[Validate([
        'required',
        'min:2',
        'max:'.Constants::TEAMCHARS,
    ], message: [
        'min' => 'A team name must have at least 2 characters',
        'max' => 'A team name can\'t be longer than '.Constants::TEAMCHARS.' characters',
    ])]
    public string $name;

    #[Validate([
        'required',
        'exists:App\Models\Venue,id',
    ], message: [
        'required' => 'A team must have a venue (bar)',
        'exists' => 'The selected venue does not exist',
    ])]
    public ?int $venue_id;

    #[Validate([
        'required',
        'exists:App\Models\Season,id',
    ], message: [
        'required' => 'Please select a Season',
        'exists' => 'The selected Season does not exist',
    ])]
    public int $season_id;

    #[Validate(['nullable', 'text'])]
    public ?string $remark;

    #[Validate(['nullable', 'exists:App\Models\User,id'])]
    public ?int $captain_id;

    public function setTeam(Team $team): void
    {
        $this->team = $team;
        $this->name = $this->team->name;
        $this->venue_id = $this->team->venue_id;
        $this->season_id = $this->team->season_id;
        $this->remark = $this->team->remark;
        // The id selects the first captain in the team
        $this->captain_id = $this->team->players()
            ->where('captain', true)
            ->first()
            ?->user_id;
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

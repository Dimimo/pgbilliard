<?php

namespace App\Livewire\Forms;

use App\Models\Player;
use Livewire\Attributes\Rule;
use Livewire\Form;

class PlayerForm extends Form
{
    public Player $player;

    #[Rule('bool')]
    public bool $captain = false;

    #[Rule('nullable|unique:App\Models\User,id')]
    public ?int $user_id;

    #[Rule('nullable|unique:App\Models\Team,id')]
    public int $team_id;

    public function setPlayer(Player $player)
    {
        $this->player = $player;
        $this->captain = $this->player->captain;
        $this->user_id = $this->player->user_id;
        $this->team_id = $this->player->team_id;
    }

    public function store()
    {
        $this->validate();
        Player::create($this->only(['captain', 'user_id', 'team_id']));
    }

    public function update()
    {
        $this->validate();
        $this->player->update($this->all());
        $this->player->refresh();
    }
}

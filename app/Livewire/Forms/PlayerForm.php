<?php

namespace App\Livewire\Forms;

use App\Models\Player;
use App\Models\Team;
use Livewire\Form;
use Illuminate\Validation\Rule as ValidationRule;

class PlayerForm extends Form
{
    public Player $player;

    public bool $captain = false;

    public ?int $user_id;

    public ?int $team_id;

    public function rules(): array
    {
        return [
            'captain' => 'bool',
            'user_id' => ValidationRule::unique('users')->ignore(\Auth::id()),
            'team_id' => 'required|exists:'.Team::class,
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.unique' => 'Any user can be linked to only one player, this username is already taken by another player',
            'team_id.required' => 'The player needs a team',
            'team_id.unique' => 'The given team does not exist',
        ];
    }

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

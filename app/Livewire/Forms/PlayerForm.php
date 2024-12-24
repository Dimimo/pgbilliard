<?php

namespace App\Livewire\Forms;

use App\Models\Player;
use App\Models\User;
use Auth;
use Illuminate\Validation\Rule;
use Livewire\Form;

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
            'user_id' => Rule::unique(User::class, 'id')->ignore(Auth::user()),
            'team_id' => [
                'required',
                'exists:teams,id',
            ],
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

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
        $this->captain = $player->captain;
        $this->user_id = $player->user_id;
        $this->team_id = $player->team_id;
    }

    public function store(): void
    {
        $this->validate();
        Player::create($this->only(['captain', 'user_id', 'team_id']));
    }

    public function update(): void
    {
        $validated = $this->validate();
        $this->player->update($validated);
        $this->player->refresh();
    }
}

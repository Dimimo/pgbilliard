<?php

namespace App\Livewire\Forms;

use App\Models\Player;
use App\Models\User;
use Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PlayerForm extends Form
{
    public Player $player;
    #[Validate]
    public bool $captain = false;
    #[Validate]
    public bool $active = true;
    #[Validate]
    public ?int $user_id = null;
    #[Validate]
    public ?int $team_id = null;

    public function rules(): array
    {
        return [
            'captain' => 'bool',
            'active' => 'bool',
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
        $this->fill($this->player);
    }

    public function store(): void
    {
        $this->validate();
        Player::query()->create($this->only(['captain', 'active', 'user_id', 'team_id']));
    }

    public function update(): void
    {
        $validated = $this->validate();
        $this->player->update($validated);
        $this->player->refresh();
    }
}

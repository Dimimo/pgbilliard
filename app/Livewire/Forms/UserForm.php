<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    public User $user;

    #[Rule(['unique:App\Models\User,name'])]
    public $name = '';

    #[Rule(['sometimes', 'email', 'max:254'])]
    public $email = '';

    #[Rule('nullable|max:24')]
    public ?string $contact_nr;

    #[Rule('nullable|string')]
    public ?string $gender;

    #[Rule(['nullable', 'date'])]
    public $email_verified_at;

    #[Rule(['nullable', 'date'])]
    public $last_game;

    #[Rule(['sometimes'])]
    public $password;

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->password = $this->user->password;
        $this->contact_nr = $this->user->contact_nr;
        $this->gender = $this->user->gender;
        $this->last_game = $this->user->last_game;
        $this->email_verified_at = $this->user->email_verified_at;
    }

    public function store(): User
    {
        $this->validate();
        $this->user->makeVisible(['password']);
        $user = User::create($this->user->toArray());
        $this->user->makeHidden(['password']);

        return $user;
    }

    public function update()
    {
        $this->validate();
        $this->user->update($this->all());
        $this->user->refresh();
    }
}

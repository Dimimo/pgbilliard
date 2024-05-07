<?php

namespace App\Livewire\Forms;

use App\Constants;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    public User $user;

    #[Rule([
        'sometimes',
        'alpha_dash',
        'min:2',
        'max:'.Constants::USERCHARS,
        'unique:'.User::class.',name',
    ], message: [
        'alpha_dash' => 'A name needs to be alpha-numeric, dashes (-) and underscores (_) allowed',
        'min' => 'A name needs at least 2 characters',
        'max' => 'A name can not be longer than '.Constants::USERCHARS.' characters',
        'unique' => 'This name already exists',
    ])]
    public $name = '';

    #[Rule([
        'required',
        'email',
        'max:254',
        'unique:'.User::class.',email',
    ], message: [
        'required' => 'A valid email address is required',
        'email' => 'A valid email address is required',
        'unique' => 'The email has to be unique',
    ])]
    public $email = '';

    #[Rule(['nullable', 'max:'.Constants::PHONECHARS])]
    public ?string $contact_nr;

    #[Rule(['nullable', 'string'])]
    public ?string $gender;

    #[Rule(['nullable', 'date'])]
    public $email_verified_at;

    #[Rule(['nullable', 'date'])]
    public $last_game;

    #[Rule(['sometimes'])]
    public $password;

    public function setUser(User $user): void
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

    public function update(): void
    {
        $this->validate();
        $this->user->update($this->all());
        $this->user->refresh();
    }
}

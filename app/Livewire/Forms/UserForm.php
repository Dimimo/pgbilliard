<?php

namespace App\Livewire\Forms;

use App\Constants;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public User $user;

    #[Validate([
        'sometimes',
        'alpha_dash',
        'min:2',
        'max:'.Constants::USERCHARS,
        'unique:'.User::class.',name',
    ], message: [
        'name.alpha_dash' => 'A name needs to be alpha-numeric, dashes (-) and underscores (_) allowed',
        'name.min' => 'A name needs at least 2 characters',
        'name.max' => 'A name can not be longer than '.Constants::USERCHARS.' characters',
        'name.unique' => 'This name already exists',
    ])]
    public ?string $name = '';

    #[Validate([
        'required',
        'email',
        'max:254',
        'unique:'.User::class.',email',
    ], message: [
        'email.required' => 'A valid email address is required',
        'email.email' => 'A valid email address is required',
        'email.unique' => 'The email has to be unique',
    ])]
    public ?string $email = '';

    #[Validate(['nullable', 'max:'.Constants::PHONECHARS])]
    public ?string $contact_nr;

    #[Validate(['nullable', 'string'])]
    public ?string $gender;

    #[Validate(['nullable', 'date'])]
    public ?string $email_verified_at;

    #[Validate(['nullable', 'date'])]
    public ?string $last_game;

    #[Validate(['sometimes'])]
    public ?string $password;

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
        $user = User::query()->create($this->user->toArray());
        $this->user->makeHidden(['password']);

        return $user;
    }

    public function update(): void
    {
        // only admins should have access to this method
        if (session('is_admin')) {
            $this->validateOnly('name');
            $this->user->update($this->all());
            $this->user->refresh();
        }
    }
}

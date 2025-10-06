<?php

namespace App\Livewire\Forms;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public User $user;
    #[Validate]
    public ?string $name = '';
    #[Validate]
    public ?string $email = '';
    #[Validate]
    public ?string $contact_nr = '';
    #[Validate]
    public ?string $gender;
    #[Validate]
    public ?string $email_verified_at;
    #[Validate]
    public ?string $last_game;
    #[Validate]
    public ?string $password;

    public function rules(): array
    {
        return (new UserRequest())->rules();
    }

    public function messages(): array
    {
        return (new UserRequest())->messages();
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->fill($this->user);
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
            if ($this->user->name !== $this->only('name')['name']) {
                $update_only = ['name', 'contact_nr'];
                $this->validateOnly('name');
            } else {
                $update_only = ['contact_nr'];
            }
            $this->validateOnly('contact_nr');
            $this->user->update($this->only($update_only));
            $this->user->refresh();
        }
    }
}

<?php

namespace App\Livewire\Auth;

use App\Constants;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';
    public string $contact_nr = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'contact_nr' => ['nullable', 'max:' . Constants::PHONECHARS],
            'email' => ['required', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.auth.register');
    }

    public function register(): void
    {
        $validated = $this->validate();
        $validated['password'] = Hash::make($validated['password']);
        event(new Registered($user = User::query()->create($validated)));
        auth()->login($user);
        $this->redirect(RouteServiceProvider::HOME);
    }
}

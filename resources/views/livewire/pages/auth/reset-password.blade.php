<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('components.layout');

state('token')->locked();

state([
    'email' => fn() => request()->string('email')->value(),
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'token' => ['required'],
    'email' => ['required', 'string', 'email'],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$resetPassword = function () {
    $this->validate();
    // Here we will attempt to reset the user's password. If it is successful we
    // will update the password on an actual user model and persist it to the
    // database. Otherwise we will parse the error and return the response.
    $status = Password::reset($this->only('email', 'password', 'password_confirmation', 'token'), function ($user) {
        $user->forceFill([
            'password' => Hash::make($this->password),
            'remember_token' => Str::random(60),
        ])->save();
        event(new PasswordReset($user));
    });
    // If the password was successfully reset, we will redirect the user back to
    // the application's home authenticated view. If there is an error we can
    // redirect them back to where they came from with their error message.
    if ($status != Password::PASSWORD_RESET) {
        $this->addError('email', __($status));

        return;
    }
    session()->flash('status', __($status));
    $this->redirectRoute('login', navigate: true);
};
?>

<div class="mx-auto">
    <form wire:submit="resetPassword" class="flex flex-col items-center">
        <!-- Email Address -->
        <div>
            <x-forms.input-label for="email" :value="__('Email')"/>
            <x-forms.text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus
                                autocomplete="username"/>
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-forms.input-label for="password" :value="__('Password')"/>
            <x-forms.text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" required
                                autocomplete="new-password"/>
            <x-forms.input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-forms.input-label for="password_confirmation" :value="__('Confirm Password')"/>

            <x-forms.text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password"/>

            <x-forms.input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-forms.primary-button>
                {{ __('Reset Password') }}
            </x-forms.primary-button>
        </div>
    </form>
</div>

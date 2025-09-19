<?php

use Illuminate\Support\Facades\Password;
use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('components.layout');

state(['email' => '']);

rules(['email' => ['required', 'string', 'email']]);

$sendPasswordResetLink = function () {
    $this->validate();
    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $status = Password::sendResetLink($this->only('email'));
    if ($status != Password::RESET_LINK_SENT) {
        $this->addError('email', __($status));

        return;
    }
    $this->reset('email');
    session()->flash('status', __($status));
};
?>

<div class="flex flex-col justify-center">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col items-center">
        <!-- Email Address -->
        <div>
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.text-input
                wire:model="email"
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                required
                autofocus
            />
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <x-forms.primary-button>
                {{ __('Email the password reset link') }}
            </x-forms.primary-button>
        </div>
    </form>

    <div class="mx-auto my-8 w-96 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to create a new password.') }}
    </div>
</div>

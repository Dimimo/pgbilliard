<?php

use Illuminate\Support\Facades\Password;
use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('components.layout');

state(['email' => '']);

rules(['email' => ['required', 'string', 'email']]);

$sendPasswordResetLink = function ()
{
    $this->validate();
    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $status = Password::sendResetLink($this->only('email'));
    if ($status != Password::RESET_LINK_SENT)
    {
        $this->addError('email', __($status));

        return;
    }
    $this->reset('email');
    session()->flash('status', __($status));
};
?>

<div class="mx-96">

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form wire:submit="sendPasswordResetLink" class="flex flex-col items-center">
        <!-- Email Address -->
        <div>
            <x-forms.input-label for="email" :value="__('Email')"/>
            <x-forms.text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus/>
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-forms.primary-button>
                {{ __('Email Password Reset Link') }}
            </x-forms.primary-button>
        </div>
    </form>

    <div class="my-8 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>
</div>

<?php

use App\Providers\RouteServiceProvider;
use function Livewire\Volt\layout;

layout('components.layout');

$sendVerification = function () {
    if (auth()->user()->hasVerifiedEmail()) {
        $this->redirect(session('url.intended', RouteServiceProvider::HOME), navigate: true);

        return;
    }
    auth()->user()->sendEmailVerificationNotification();
    session()->flash('status', 'verification-link-sent');
};

$logout = function () {
    auth()->guard('web')->logout();
    session()->invalidate();
    session()->regenerateToken();
    $this->redirect('/', navigate: true);
};
?>

<div class="w-96">
    <div class="mb-4 text-sm text-gray-600">
        {{ __("Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <x-forms.primary-button wire:click="sendVerification">
            {{ __('Resend Verification Email') }}
        </x-forms.primary-button>

        <button wire:click="logout" type="submit"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Log Out') }}
        </button>
    </div>
</div>

<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Validation\Rule;
use function Livewire\Volt\state;

state([
    'name' => fn() => auth()->user()->name,
    'email' => fn() => auth()->user()->email
]);

$updateProfileInformation = function () {
    $user = auth()->user();
    $validated = $this->validate([
        'name' => ['required', 'string', 'min:2', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
    ]);
    $user->fill($validated);
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
        \App\Jobs\AccountHasBeenClaimed::dispatch($user);
        \App\Jobs\EmailHasBeenChanged::dispatch($user);
    }
    $user->save();
    $this->dispatch('profile-updated', name: $user->name);
};

$sendVerification = function () {
    $user = auth()->user();
    if ($user->hasVerifiedEmail()) {
        $path = session('url.intended', RouteServiceProvider::HOME);
        $this->redirect($path);

        return;
    }
    $user->sendEmailVerificationNotification();
    session()->flash('status', 'verification-link-sent');
};
?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-forms.input-label for="name" :value="__('Name')"/>
            <x-forms.text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name"/>
            <x-forms.input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>

        <div>
            <x-forms.input-label for="email" :value="__('Email')"/>
            <x-forms.text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username"/>
            <x-forms.input-error class="mt-2" :messages="$errors->get('email')"/>

            @if (auth()->user() instanceof MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-forms.primary-button>{{ __('Save') }}</x-forms.primary-button>

            <x-forms.action-message class="mr-3" on="profile-updated">
                {{ __('Saved') }}
            </x-forms.action-message>
        </div>
    </form>
</section>

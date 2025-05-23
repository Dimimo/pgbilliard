<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('components.layout');

state(['email' => '', 'password' => '', 'remember' => false]);

rules([
    'email' => ['required', 'string', 'email'],
    'password' => ['required', 'string'],
    'remember' => ['boolean'],
]);

$login = function () {
    $this->validate();
    $throttleKey = Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        event(new Lockout(request()));
        $seconds = RateLimiter::availableIn($throttleKey);
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }
    if (!auth()->attempt($this->only(['email', 'password'], $this->remember))) {
        RateLimiter::hit($throttleKey);
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }
    RateLimiter::clear($throttleKey);
    session()->regenerate();
    session(['last_login' => auth()->user()->updated_at]);
    auth()->user()->touch('updated_at');
    $this->redirect(session('url.intended', RouteServiceProvider::HOME));
};
?>

<div class="mx-auto">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form wire:submit="login" class="flex flex-col items-center">
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

            <x-forms.text-input wire:model="password" id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password"/>

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="remember" id="remember" type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                       name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    wire:navigate
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-forms.primary-button class="ml-3">
                {{ __('Log in') }}
            </x-forms.primary-button>
        </div>
    </form>
</div>

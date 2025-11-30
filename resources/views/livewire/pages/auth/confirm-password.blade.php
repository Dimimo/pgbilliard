<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('components.layout');

state(['password' => '']);

rules(['password' => ['required', 'string']]);

$confirmPassword = function (): void {
    $this->validate();
    if (!auth()->guard('web')->validate([
        'email' => auth()->user()->email,
        'password' => $this->password,
    ])) {
        throw ValidationException::withMessages([
            'password' => __('auth.password'),
        ]);
    }
    session(['auth.password_confirmed_at' => time()]);
    $this->redirect(session('url.intended', RouteServiceProvider::HOME), navigate: true);
};
?>

<div class="w-96">
    <div class="my-8 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form wire:submit="confirmPassword" class="flex flex-col items-center">
        <!-- Password -->
        <div>
            <x-forms.input-label for="password" :value="__('Password')" />

            <x-forms.text-input
                wire:model="password"
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 flex justify-end">
            <x-forms.primary-button>
                {{ __('Confirm') }}
            </x-forms.primary-button>
        </div>
    </form>
</div>

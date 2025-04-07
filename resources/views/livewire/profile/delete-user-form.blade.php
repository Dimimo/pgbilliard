<?php

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state(['password' => '']);

rules(['password' => ['required', 'string', 'current_password']]);

$deleteUser = function () {
    $this->validate();
    tap(auth()->user(), fn() => auth()->logout())->delete();
    session()->invalidate();
    session()->regenerateToken();
    $this->redirect('/', navigate: true);
};
?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
            {{__('Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-forms.danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-forms.danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                {{__('Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-forms.input-label for="password" value="{{ __('Password') }}" class="sr-only"/>

                <x-forms.text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-forms.input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <div class="mt-6 flex justify-end">
                <x-forms.secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-forms.secondary-button>

                <x-forms.danger-button class="ml-3">
                    {{ __('Delete Account') }}
                </x-forms.danger-button>
            </div>
        </form>
    </x-modal>
</section>

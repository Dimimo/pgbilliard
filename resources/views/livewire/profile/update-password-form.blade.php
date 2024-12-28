<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
          'current_password'      => '',
          'password'              => '',
          'password_confirmation' => ''
      ]);

rules([
          'current_password' => ['required', 'string', 'current_password'],
          'password'         => ['required', 'string', Password::defaults(), 'confirmed'],
      ]);

$updatePassword = function ()
{
    try
    {
        $validated = $this->validate();
    } catch (ValidationException $e)
    {
        $this->reset('current_password', 'password', 'password_confirmation');
        throw $e;
    }
    auth()->user()->update([
                               'password' => Hash::make($validated['password']),
                           ]);
    $this->reset('current_password', 'password', 'password_confirmation');
    $this->dispatch('password-updated');
};
?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a secure password. The current password is \'secret\' and should be filled in.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-forms.input-label for="current_password" :value="__('Current Password')"/>
            <x-forms.text-input wire:model="current_password" id="current_password" name="current_password" type="password" class="mt-1 block w-full"
                          autocomplete="current-password"/>
            <x-forms.input-error :messages="$errors->get('current_password')" class="mt-2"/>
        </div>

        <div>
            <x-forms.input-label for="password" :value="__('New Password')"/>
            <x-forms.text-input wire:model="password" id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password"/>
            <x-forms.input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>

        <div>
            <x-forms.input-label for="password_confirmation" :value="__('Confirm Password')"/>
            <x-forms.text-input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full"
                          autocomplete="new-password"/>
            <x-forms.input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex items-center gap-4">
            <x-forms.primary-button>{{ __('Save') }}</x-forms.primary-button>

            <x-forms.action-message class="mr-3" on="password-updated">
                {{ __('Saved.') }}
            </x-forms.action-message>
        </div>
    </form>
</section>

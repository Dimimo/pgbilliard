<?php

use App\Constants;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Validation\Rule;
use function Livewire\Volt\state;

state([
          'contact_nr' => fn() => auth()->user()->contact_nr,
      ]);

$updateContactNr = function ()
{
    $user      = auth()->user();
    $validated = $this->validate([
                                     'contact_nr' => [
                                         'nullable',
                                         'string',
                                         'max:' . Constants::PHONECHARS,
                                     ],
                                 ]);
    $user->fill($validated);
    $user->save();
    $this->dispatch('contact-updated', name: $user->name);
};
?>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Contact Number
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            You may leave this empty. Except for bar owners and captains.
        </p>
    </header>

    <form wire:submit="updateContactNr" class="mt-6 space-y-6">
        <div>
            <x-input-label for="contact_nr"/>
            <x-text-input wire:model="contact_nr" id="contact_nr" name="contact_nr" type="text" class="mt-1 block w-full" required autofocus
                          autocomplete="contact_nr"/>
            <x-input-error class="mt-2" :messages="$errors->get('contact_nr')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="mr-3" on="contact-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>

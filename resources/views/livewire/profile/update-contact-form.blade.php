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

$updateContactNr = function () {
    $user = auth()->user();
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
            {{__('Contact Number')}}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{__('You may leave this empty, except for bar owners and captains')}}.
        </p>
    </header>

    <form wire:submit="updateContactNr" class="mt-6 space-y-6">
        <div>
            <x-forms.input-label for="contact_nr"/>
            <x-forms.text-input wire:model="contact_nr" id="contact_nr" name="contact_nr" type="text" class="mt-1 block w-full" required autofocus
                                autocomplete="contact_nr"/>
            <x-forms.input-error class="mt-2" :messages="$errors->get('contact_nr')"/>
        </div>

        <div class="flex items-center gap-4">
            <x-forms.primary-button>{{ __('Save') }}</x-forms.primary-button>

            <x-forms.action-message class="mr-3" on="contact-updated">
                {{ __('Saved') }}
            </x-forms.action-message>
        </div>
    </form>
</section>

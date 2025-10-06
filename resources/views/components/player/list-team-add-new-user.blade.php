<div class="flex flex-col items-center">
    <div class="mt-1 p-2">
        <div class="text-center text-xl">
            {{ __('Or add a new player') }}
        </div>
    </div>
    <div class="flex items-center p-2">
        <label class="mr-2" for="user_form.name">{{ __('Name') }}</label>
        <input id="user_form.name" type="text" wire:model.blur="user_form.name" />
        <span class="w-10 flex-none">
            <x-forms.spinner target="user_form.name" />
        </span>
    </div>
    <div class="pb-2">
        @error('user_form.name')
            <span class="text-red-700">{{ $message }}</span>
        @enderror
    </div>
    <div class="flex items-center p-2">
        <label class="mr-2" for="user_form.email">Email</label>
        <input id="user_form.email" type="text" wire:model.blur="user_form.email" />
        <span class="w-10 flex-none">
            <x-forms.spinner target="user_form.email" />
        </span>
    </div>
    <div>
        @error('user_form.email')
            <span class="text-red-700">{{ $message }}</span>
        @enderror
    </div>
    <div class="text-sm italic text-gray-500">
        {{ __("If you don't have the person's email, it is auto generated") }}.
    </div>
    <div class="p-2">
        <div class="flex items-center py-2">
            <label class="mr-2" for="user_form.contact_nr">Contact</label>
            <input id="user_form.contact_nr" type="text" wire:model.blur="user_form.contact_nr" />
            <span class="w-10 flex-none"></span>
        </div>

        <div class="text-sm italic text-gray-500">
            {{ __("You can leave this empty if you don't have the number") }}
        </div>
        <div>
            @error('user_form.contact_nr')
                <span class="text-red-700">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="p-2">
        <x-forms.primary-button>Create</x-forms.primary-button>
    </div>
    @if ($errors->any())
        <div class="p-2 text-red-700">
            <ul class="list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-forms.spinner target="addUser" />
    <x-forms.action-message class="p-2" on="user-created" class="text-xl">
        {{ __('User created and added to your team! A reminder has been sent with the login info.') }}
    </x-forms.action-message>
</div>

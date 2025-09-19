<div class="mx-auto mt-6 w-max">
    <form wire:submit="{{ $new ? 'create' : 'update' }}">
        <div class="p-4">
            <x-forms.input-label for="name" class="text-left">
                {{ __('Room name') }}
                <span class="text-sm">(max {{ \App\Constants::CHATROOM_TITLE }} chars)</span>
            </x-forms.input-label>

            <x-forms.text-input
                wire:model="name"
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                autofocus
                autocomplete="name"
                maxlength="{{ \App\Constants::CHATROOM_TITLE }}"
            />
            <x-forms.input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="p-4">
            <x-forms.checkbox :checked="$private" for="private" wire:model="private">
                <x-forms.input-label for="private" value="{{__('Is this room private')}}?" />
            </x-forms.checkbox>
            <x-forms.input-error class="mt-2" :messages="$errors->get('private')" />
        </div>

        <div class="grid grid-cols-1 gap-4 p-4">
            <x-forms.primary-button>
                {{ $new ? __('Create the new Room') : __('Update your Chat Room') }}
            </x-forms.primary-button>
            <x-forms.spinner target="create, update" />

            <x-forms.action-message class="mr-3" on="room-created">
                {{ __('Room created') }}!
            </x-forms.action-message>
            <x-forms.action-message class="mr-3" on="room-updated">
                {{ __('Room updated') }}!
            </x-forms.action-message>
        </div>
    </form>
</div>

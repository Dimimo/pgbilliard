<div class="mx-auto w-max mt-6">
    <form wire:submit="{{ $new ? 'create' : 'update' }}">
        <div class="p-4">
            <x-input-label for="name" value="Room name" class="text-left"/>
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" autofocus
                          autocomplete="name"/>
            <x-input-error class="mt-2" :messages="$errors->get('name')"/>
        </div>

        <div class="p-4">
            <x-checkbox :checked="$private" for="private" wire:model="private">
                <x-input-label for="private" value="Is this room private?"/>
            </x-checkbox>
            <x-input-error class="mt-2" :messages="$errors->get('private')"/>
        </div>

        <div class="p-4 grid grid-cols-1 gap-4">
            <x-primary-button>
                {{ $new ? 'Create the new Room' : 'Update your Chat Room' }}
            </x-primary-button>
            <x-spinner target="create, update"/>

            <x-action-message class="mr-3" on="room-created">
                Room created!
            </x-action-message>
            <x-action-message class="mr-3" on="room-updated">
                Room updated!
            </x-action-message>
        </div>
    </form>
</div>

@props(['player'])

<div class="flex flex-row flex-nowrap items-center space-x-2">
    <div class="flex flex-col">
        <div>
            <label for="user_edit.name_{{ $player->id }}"></label>
            <input
                id="user_edit.name_{{ $player->id }}"
                type="text"
                wire:model.live.debounce.1000ms="user_form.name"
            />
        </div>
        <div>
            @error('user_form.name')
                <span class="text-red-700">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="flex flex-col">
        <div>
            <label for="user_edit.contact_nr_{{ $player->id }}"></label>
            <input
                id="user_edit.contact_nr_{{ $player->id }}"
                type="text"
                wire:model.live.debounce.1000ms="user_form.contact_nr"
            />
        </div>
        <div>
            @error('user_form.contact_nr')
                <span class="text-red-700">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <x-forms.secondary-button type="submit" x-on:click="edit = !edit">
        Update
    </x-forms.secondary-button>
    <x-forms.spinner />
</div>

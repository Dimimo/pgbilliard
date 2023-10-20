<div>
    <form wire:submit="save">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-2 mt-1 text-right text-xl">
                <label for="name">Name</label>
            </div>
            <div class="p-2">
                <input id="name" type="text" wire:model.live="venue_form.name">
                <div>
                    @error('venue_form.name') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="p-2 mt-1 text-right text-xl">
                <label for="address">Address</label>
            </div>
            <div class="p-2">
                <input class="w-full" id="address" type="text" wire:model="venue_form.address">
            </div>
            <div class="p-2 mt-1 text-right text-xl">
                <label for="user_id">Owner</label>
            </div>
            <div class="p-2">
                <select id="user_id" wire:model="venue_form.user_id">
                    <option> -- owner select --</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="p-2 mt-1 text-right text-xl">
                <label for="owner_name">Owner name</label>
            </div>
            <div class="p-2">
                <input id="owner_name" type="text" wire:model="venue_form.contact_name">
            </div>
            <div class="p-2 mt-1 text-right text-xl">
                <label for="owner_nr">Owner contact</label>
            </div>
            <div class="p-2">
                <input id="owner_nr" type="text" wire:model="venue_form.contact_nr">
            </div>
            <div class="p-2 mt-1 text-right text-xl">
                <label for="remark">Remark</label>
            </div>
            <div class="p-2">
                <input class="w-full" id="remark" type="text" wire:model="venue_form.remark">
            </div>
            <div class="p-2 mt-1 text-right text-xl">
                <label for="lat">Latitude</label>
            </div>
            <div class="p-2">
                <input id="lat" type="text" wire:model="venue_form.lat">
            </div>
            <div class="p-2 mt-1 text-right text-xl">
                <label for="lng">Longitude</label>
            </div>
            <div class="p-2">
                <input id="lng" type="text" wire:model="venue_form.lng">
            </div>
            <div></div>
            <div class="text-left">
                <div class="flex items-center gap-4">
                    <x-primary-button>Save</x-primary-button>
                    <x-spinner target="save"/>
                    <x-action-message class="mx-3" on="venue-updated">
                        Saved!
                    </x-action-message>
                </div>
            </div>
        </div>
    </form>
</div>

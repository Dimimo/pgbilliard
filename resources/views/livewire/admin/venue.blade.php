<div>
    <form wire:submit="save">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-2 mt-1 text-right text-xl">
                <x-input-label value="Name"/>
            </div>
            <div class="p-2">
                <x-text-input id="name" wire:model.live.debounce.500ms="venue_form.name"/>
                <div>
                    @error('venue_form.name') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="p-2 mt-1 text-right text-xl">
                <x-input-label label="address" value="Address/Description"/>
            </div>
            <div class="p-2">
                <x-text-input id="address" class="w-full" wire:model="venue_form.address"/>
                <div>
                    @error('venue_form.address') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="p-2 mt-1 text-right text-xl">
                <label for="user_id">Owner</label>
            </div>
            <div class="p-2">
                <select id="user_id" wire:model.live="venue_form.user_id">
                    <option value="0"> -- owner select --</option>
                    @foreach($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                <div class="text-sm text-gray-700 italic">
                    The choice of an owner (from the 'users' table) is preferred and has priority.<br>
                    The owner can change the details of the venue they are responsible for.<br>
                    In other words: they have access to this form.
                </div>
            </div>
            @if ($venue_form->show_name)
                <div class="p-2 mt-1 text-right text-xl">
                    <x-input-label id="contact_name" value="Contact name"/>
                </div>
                <div class="p-2">
                    <x-text-input id="contact_name" wire:model="venue_form.contact_name"/>
                    <div>
                        @error('venue_form.contact_name') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="p-2 mt-1 text-right text-xl">
                    <x-input-label id="contact_nr" value="Contact number"/>
                </div>
                <div class="p-2">
                    <x-text-input id="contact_nr" wire:model="venue_form.contact_nr"/>
                    <div>
                        @error('venue_form.contact_nr') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                </div>

            @endif
            <div class="p-2 mt-1 text-right text-xl">
                <x-input-label id="remark" value="Remark"/>
            </div>
            <x-text-input id="remark" class="p-2" wire:model="venue_form.remark"/>

            <div class="p-2 mt-1 text-right text-xl">
                <x-input-label id="lat" value="Latitude"/>
            </div>
            <div class="p-2">
                <x-text-input id="lat" wire:model="venue_form.lat"/>
                <div>
                    @error('venue_form.lat') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="p-2 mt-1 text-right text-xl">
                <x-input-label id="lng" value="Longitude"/>
            </div>
            <div class="p-2">
                <x-text-input id="lng" wire:model="venue_form.lng"/>
                <div>
                    @error('venue_form.lng') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
            </div>

            <div></div>
            <div class="p-2 mt-1 text-right">
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

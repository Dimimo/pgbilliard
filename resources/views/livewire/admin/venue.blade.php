<div>
    <form wire:submit="save">
        <div class="grid grid-cols-2 gap-4">
            <div class="mt-1 p-2 text-right text-xl">
                <x-forms.input-label value="Name" />
            </div>
            <div class="p-2">
                <x-forms.text-input id="name" wire:model.live.debounce.1000ms="venue_form.name" />
                <div>
                    @error('venue_form.name')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-1 p-2 text-right text-xl">
                <x-forms.input-label label="address" value="Address/Description" />
            </div>
            <div class="p-2">
                <x-forms.text-input id="address" class="w-full" wire:model="venue_form.address" />
                <div>
                    @error('venue_form.address')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-1 p-2 text-right text-xl">
                <label for="user_id">Owner</label>
            </div>
            <div class="p-2">
                <select id="user_id" wire:model.live="venue_form.user_id">
                    <option value="">-- owner select --</option>
                    @foreach ($users as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
                <div class="text-sm italic text-gray-700">
                    @if (session('is_admin'))
                        The choice of the bar owner (from the 'users' table) is preferred and has priority.
                        The owner can change the details of the venue they are responsible for (name and address).
                        In other words: they have access to this form.
                    @else
                            Warning: if you change the Owner, you will have no more access to this
                            form! There is not much to it, except the short address description.
                            Latitude and Longitude are foreseen for Google Maps. Not implemented so
                            far. Maybe one day...
                    @endif
                </div>
            </div>
            @if ($venue_form->show_name)
                <div class="mt-1 p-2 text-right text-xl">
                    <x-forms.input-label id="contact_name" value="Contact name" />
                </div>
                <div class="p-2">
                    <x-forms.text-input id="contact_name" wire:model="venue_form.contact_name" />
                    <div>
                        @error('venue_form.contact_name')
                            <span class="text-red-700">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mt-1 p-2 text-right text-xl">
                    <x-forms.input-label id="contact_nr" value="Contact number" />
                </div>
                <div class="p-2">
                    <x-forms.text-input id="contact_nr" wire:model="venue_form.contact_nr" />
                    <div>
                        @error('venue_form.contact_nr')
                            <span class="text-red-700">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            @endif

            <div class="mt-1 p-2 text-right text-xl">
                <x-forms.input-label id="remark" value="Remark" />
            </div>
            <x-forms.text-input id="remark" class="p-2" wire:model="venue_form.remark" />

            <div class="mt-1 p-2 text-right text-xl">
                <x-forms.input-label id="lat" value="Latitude" />
            </div>
            <div class="p-2">
                <x-forms.text-input id="lat" wire:model="venue_form.lat" />
                <div>
                    @error('venue_form.lat')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-1 p-2 text-right text-xl">
                <x-forms.input-label id="lng" value="Longitude" />
            </div>
            <div class="p-2">
                <x-forms.text-input id="lng" wire:model="venue_form.lng" />
                <div>
                    @error('venue_form.lng')
                        <span class="text-red-700">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div></div>
            <div class="mt-1 p-2 text-right">
                <div class="flex items-center gap-4">
                    <x-forms.primary-button>Save</x-forms.primary-button>
                    <x-forms.spinner target="save" />
                    <x-forms.action-message class="mx-3" on="venue-updated">
                        Saved!
                    </x-forms.action-message>
                </div>
            </div>
        </div>
    </form>
</div>

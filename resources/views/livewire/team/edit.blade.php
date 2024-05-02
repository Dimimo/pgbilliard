<section>
    <div class="text-center border-2 border-green-500 rounded-md p-4 my-4">
        <form wire:submit="team_save">
            <div class="grid justify-items-center gap-4">
                <div>
                    <label for="team_form.name" class="text-lg mr-2">
                        The team
                    </label>
                    <input id="team_form.name" type="text" wire:model="team_form.name">
                    <div>
                        @error('team_form.name') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="venue_id" class="text-lg mr-2">
                        Plays at
                    </label>
                    <select id="venue_id" wire:model="team_form.venue_id">
                        <option readonly>Select venue...</option>
                        @foreach($venues->sortBy('name') as $venue)
                            <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('team_form.venue_id') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <div class="text-right col-start-2">
                        <x-primary-button class="">
                            Save
                        </x-primary-button>
                    </div>
                    <x-spinner target="team_save"/>
                    <x-action-message class="mx-3" on="team-updated">
                        Saved!
                    </x-action-message>
                </div>
            </div>
        </form>
        @can ('update', $venue)
            <a href="{{ route('venues.edit', ['venue' => $team_form->team->venue]) }}" class="flex justify-end p-4" wire:navigate>
                <div class="mr-2">
                    <img src="{{ secure_asset('svg/pen-square.svg') }}" alt="" width="24" height="24">
                </div>
                <div class="text-blue-700">
                    Edit the venue's details
                </div>
            </a>
        @endcan
    </div>
</section>

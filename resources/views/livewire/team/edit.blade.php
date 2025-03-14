<section>
    <div class="my-4 rounded-md border-2 border-green-500 p-4 text-center">
        <form wire:submit="create">
            <div class="grid justify-items-center gap-4">
                <div>
                    <label for="team_form.name" class="mr-2 text-lg">
                        The team
                    </label>
                    <input id="team_form.name" type="text" wire:model="team_form.name">
                    <div>
                        @error('team_form.name') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="venue_id" class="mr-2 text-lg">
                        Plays at
                    </label>
                    <select id="venue_id" wire:model="team_form.venue_id">
                        @foreach($venues->sortBy('name') as $venue)
                            <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('team_form.venue_id') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <div class="col-start-2 text-right">
                        <x-forms.primary-button>
                            Save
                        </x-forms.primary-button>
                    </div>
                    <x-forms.spinner class="mt-2"/>
                    <x-forms.action-message class="mx-3" on="team-updated">
                        <div class="mt-1 text-lg">Saved!</div>
                    </x-forms.action-message>
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

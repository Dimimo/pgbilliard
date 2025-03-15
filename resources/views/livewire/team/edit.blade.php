<section>
    <div class="my-4 rounded-md border-2 border-green-500 text-center">
        <form class="p-4" wire:submit="create">
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
            <div class="mr-4 mb-1 flex justify-end">
                <a
                    href="{{ route('venues.edit', ['venue' => $team_form->team->venue]) }}"
                    class="inline-block link text-blue-700"
                    wire:navigate
                >
                    <x-svg.pen-to-square-solid color="fill-blue-700" size="4" padding="mr-2 mb-1"/>
                    Edit the venue's details
                </a>
            </div>
        @endcan
    </div>
</section>

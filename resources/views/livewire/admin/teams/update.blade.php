@props(['form'])
<div>
    <div class="flex items-center w-full my-2 pl-2">
        <input type="hidden" name="team.{{ $form->team->id }}.id" wire:model.defer="form.id">

        <label for="teams[{{ $form->team->id }}]['name']" class="inline-block mr-2">The team</label>
        <input type="text" id="teams[{{ $form->team->id }}]['name']" wire:model.live.debounce="form.name"
               class="shadow-sm border-1 border-blue-300 focus:outline-none p-3 inline-block sm:text-sm rounded-md"
               placeholder="{{ $form->name }}">

        <label for="teams[{{ $form->team->id }}['venue_id']" class="inline-block mx-2">
            Plays at
        </label>
        <select class="inline-block" id="teams[{{ $form->team->id }}['venue_id']" wire:model.live="form.venue_id">
            <option>Select venue...</option>
            @foreach($venues as $venue)
                <option value="{{ $venue->id }}">{{ $venue->name }}</option>
            @endforeach
        </select>

        <label for="teams[{{$form->team->id}}]['user_id']" class="inline-block mx-2">
            Captain
        </label>
        <select class="inline-block" id="teams[{{$form->team->id}}]['user_id']" wire:model.live="form.captain_id">
            <option>Select captain...</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

        @if(!$form->team->hasGames())
            <div class="inline-block ml-2">
                <button
                    type="submit"
                    title="Remove this team"
                    wire:confirm="Do you want to remove this team? You can always add again later"
                    wire:click="$dispatch('remove-team', { team_id: {{ $form->team->id }} })"
                >
                    <img
                        class="mx-auto" src="{{ secure_asset('svg/minus-box-fill.svg') }}"
                        alt="Remove"
                        width="24"
                        height="24"
                    >
                </button>
            </div>
        @endif
    </div>
    <div class="ml-12">
        @error('form.user_id') <span class="text-red-700">{{ $message }}</span> @enderror
        @error('form.name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        @error('form.venue_id') <span class="text-red-700">{{ $message }}</span> @enderror
    </div>
</div>


@props(['form'])
<div
    x-data="{ highlight: false }"
    :class="{ 'bg-yellow-100 transition ease-in-out duration-1000': highlight }"
    x-on:teams-updated="highlight = true; setTimeout(() => highlight = false, 1000)"
    class="rounded-lg py-1 pl-2"
>
    <div
        class="flex w-full items-center"
    >
        <input type="hidden" name="team.{{ $form->team->id }}.id" wire:model.defer="form.id">

        <label for="team[{{ $form->team->id }}]" class="mr-2 inline-block">The team</label>
        <input
            type="text"
            id="team[{{ $form->team->id }}]"
            wire:model.live.debounce="form.name"
            placeholder="{{ $form->name }}">

        <label for="teams-venue[{{ $form->team->id }}" class="mx-2 inline-block">
            Plays at
        </label>
        <select
            class="inline-block"
            id="teams-venue[{{ $form->team->id }}"
            wire:change="changeTeamVenue($event.target.value)"
        >
            <option>Select venue...</option>
            @foreach($form->venues as $venue)
                <option
                    wire:key="change-venue-{{ $form->team->id }}-{{ $venue->id }}"
                    value="{{ $venue->id }}"
                    @selected($form->venue_id === $venue->id)
                >
                    {{ $venue->name }}
                </option>
            @endforeach
        </select>

        <label for="teams-captain[{{$form->team->id}}]" class="mx-2 inline-block">
            Captain
        </label>
        <select
            class="inline-block"
            id="teams-captain[{{$form->team->id}}]"
            wire:change="changeTeamCaptain($event.target.value)"
        >
            <option>Select captain...</option>
            @foreach($form->users as $user)
                <option
                    wire:key="change-captain-{{ $form->team->id }}-{{ $user->id }}"
                    value="{{ $user->id }}"
                    @selected($form->captain_id === $user->id)
                >
                    {{ $user->name }}
                </option>
            @endforeach
        </select>

        @if(!$form->team->hasGames())
            <div class="ml-2 inline-block">
                <button
                    type="submit"
                    title="Remove this team"
                    wire:confirm="Do you want to remove this team? You can always add again later"
                    wire:click="$dispatch('remove-team', { team_id: {{ $form->team->id }} })"
                >
                    <x-svg.square-minus-solid color="fill-orange-400" size="6"/>
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


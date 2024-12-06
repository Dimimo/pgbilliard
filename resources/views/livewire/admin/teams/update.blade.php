@props(['team_form'])
<div class="w-full block content-center my-2 pl-2" wire:key="{{ $team_form->team->id }}">
    <input type="hidden" name="team.{{ $team_form->team->id }}.id" wire:model.defer="team_form.id">

    <label for="teams[{{ $team_form->team->id }}]['name']" class="inline-block mr-2">The team</label>
    <input type="text" id="teams[{{ $team_form->team->id }}]['name']" wire:model.live="team_form.name"
           class="shadow-sm border-1 border-blue-300 focus:outline-none p-3 inline-block sm:text-sm rounded-md"
           placeholder="{{ $team_form->name }}">
    @error('team_form.name') <span class="text-xs text-red-600">{{ $message }}</span> @enderror

    <label for="teams[{{ $team_form->team->id }}['venue_id']" class="inline-block mx-2">
        Plays at
    </label>
    <select class="inline-block" id="teams[{{ $team_form->team->id }}['venue_id']" wire:model.live="team_form.venue_id">
        <option>Select venue...</option>
        @foreach($venues as $venue)
            <option value="{{ $venue->id }}">{{ $venue->name }}</option>
        @endforeach
    </select>
    <div class="inline-block">
        @error('team_form.venue_id') <span class="text-red-700">{{ $message }}</span> @enderror
    </div>

    <label for="teams[{{$team_form->team->id}}]['user_id']" class="inline-block mx-2">
        Captain
    </label>
    <select class="inline-block" id="teams[{{$team_form->team->id}}]['user_id']" wire:model.live="team_form.id">
        <option>Select captain...</option>
{{--        @foreach($users as $id => $name)--}}
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    @if(!$team_form->team->hasGames())
        <div class="inline-block ml-2 mt-2">
            <button
                type="button"
                title="Remove this team"
                @click="$parent.removeTeam({{ $team_form->team->id }})"
                wire:confirm="Do you want to remove this team?\nYou cqn always add again later."
            >
                <img class="mx-auto" src="{{ secure_asset('svg/minus-box-fill.svg') }}" alt="Remove" width="24"
                     height="24">
            </button>
        </div>
    @endif
    <div>
        @error('team_form.user_id') <span class="text-red-700">{{ $message }}</span> @enderror
    </div>
</div>

@props(['teamNr', 'teams'])

<div class="flex flex-col">
    <label for="{{ $teamNr }}">{{ $slot }}</label>
    <select
        class="mb-1 mr-4 w-auto rounded border border-gray-500 py-1 pl-4 pr-8 text-base text-gray-800 focus:border-green-500"
        id="{{ $teamNr }}"
        wire:model.change="event.{{ $teamNr }}"
    >
        <option>-- {{ $slot }}</option>
        @foreach ($teams as $team)
            <option value="{{ $team->id }}" wire:key="{{ $teamNr }}_{{ $team->id }}">
                {{ $team->name }}
            </option>
        @endforeach
    </select>

    @error('event.'.$teamNr)
        <div class="space-y-1 text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>

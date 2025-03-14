@props(['teamNr', 'teams'])

<div class="flex flex-col">
    <label for="{{ $teamNr }}">{{ $slot }}</label>
    <select
        class="w-auto py-1 pl-4 pr-8 mr-4 mb-1 text-base text-gray-800 border border-gray-500 focus:border-green-500 rounded"
        id="{{ $teamNr }}" wire:model.change="event.{{ $teamNr }}"
    >
        <option>-- {{ $slot }}</option>
        @foreach($teams as $team)

            <option
                value="{{ $team->id }}"
                wire:key="{{ $teamNr }}_{{ $team->id }}"
            >
                {{ $team->name }}
            </option>
        @endforeach
    </select>

    @error('event.'.$teamNr)
    <div class="text-sm text-red-600 space-y-1">{{ $message }}</div>
    @enderror

</div>

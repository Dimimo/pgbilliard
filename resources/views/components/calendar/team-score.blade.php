@props(['scoreNr'])

<div class="flex flex-col">
    <label for="{{ $scoreNr }}">
        {{ $slot }}
    </label>
    <div class="relative flex items-stretch w-full">
        <input
            class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-500 rounded"
            type="text" id="{{ $scoreNr }}" wire:model="event.{{ $scoreNr }}">
    </div>
    @error('event.'.$scoreNr)
    <div class="text-sm text-red-600 space-y-1">{{ $message }}</div> @enderror
</div>

@props(['scoreNr'])

<div class="flex flex-col">
    <label for="{{ $scoreNr }}">
        {{ $slot }}
    </label>
    <div class="relative flex w-full items-stretch">
        <input
            class="mb-1 block w-full appearance-none rounded border border-gray-500 bg-white px-2 py-1 text-base leading-normal text-gray-800"
            type="text"
            id="{{ $scoreNr }}"
            wire:model="event.{{ $scoreNr }}"
        />
    </div>
    @error('event.'.$scoreNr)
        <div class="space-y-1 text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>

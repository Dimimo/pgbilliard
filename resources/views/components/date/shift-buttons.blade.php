@props(['date'])
<div class="mb-2">
    <button class="border border-blue-600 bg-blue-300 px-2 rounded-lg" wire:click="changeDate({{ $date->id }}, -7)">
        - week
    </button>
    <button class="border border-blue-600 bg-blue-100 px-2 rounded-lg" wire:click="changeDate({{ $date->id }}, -1)">
        - day
    </button>
    <span class="mx-3">
        {{ $date->date->format('l \t\h\e jS \o\f M Y') }}
    </span>

    <button class="border border-green-500 bg-green-100 px-2 rounded-lg" wire:click="changeDate({{ $date->id }}, 1)">
        + day
    </button>
    <button class="border border-green-500 bg-green-300 px-2 rounded-lg" wire:click="changeDate({{ $date->id }}, 7)">
        + week
    </button>
</div>

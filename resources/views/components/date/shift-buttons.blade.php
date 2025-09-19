@props(['date'])
<div class="mb-2">
    <button
        class="rounded-lg border border-blue-600 bg-blue-300 px-2"
        wire:click="changeDate({{ $date->id }}, -7)"
    >
        - {{ __('week') }}
    </button>
    <button
        class="rounded-lg border border-blue-600 bg-blue-100 px-2"
        wire:click="changeDate({{ $date->id }}, -1)"
    >
        - {{ __('day') }}
    </button>
    <span class="mx-3">
        {{ $date->date->format('l \t\h\e jS \o\f M Y') }}
    </span>

    <button
        class="rounded-lg border border-green-500 bg-green-100 px-2"
        wire:click="changeDate({{ $date->id }}, 1)"
    >
        + {{ __('day') }}
    </button>
    <button
        class="rounded-lg border border-green-500 bg-green-300 px-2"
        wire:click="changeDate({{ $date->id }}, 7)"
    >
        + {{ __('week') }}
    </button>
</div>

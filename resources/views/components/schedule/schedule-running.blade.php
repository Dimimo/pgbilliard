@props(['event'])

<div class="flex flex-row justify-center space-x-4">
    <a
        href="{{ route('schedule.event', ['event' => $event]) }}"
        class="text-blue-800 link"
        wire:navigate
    >
        {{ $event->team_1->name }} - {{ $event->team_2->name }}
    </a>
    <span class="italic text-gray-600">
        ({{ trans_choice('plural.day-games', $event->games()->where('win', true)->distinct('position')->count()) }})
    </span>
</div>

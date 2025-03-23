@props(['event', 'available' => true, 'can_update' => false])

<div class="flex flex-row justify-center space-x-2">
    @if ($available === true || $can_update === true)
        <div>
            <a
                href="{{ route('schedule.event', ['event' => $event]) }}"
                class="text-blue-800 link"
                wire:navigate
            >
                {{ $event->team_1->name }} - {{ $event->team_2->name }}
            </a>
        </div>
    @else
        <div>
            {{ $event->team_1->name }} - {{ $event->team_2->name }}
        </div>
    @endif
    @if ($available)
        <div class="italic text-gray-600">
            ({{ trans_choice('plural.day-games', $event->games()->where('win', true)->distinct('position')->count()) }})
        </div>
    @else
        <div class="italic text-gray-600">
            ({{__('no daily scores yet')}})
        </div>
    @endif
</div>

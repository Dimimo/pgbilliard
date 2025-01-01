@props(['date', 'old' => false])

<div class="flex flex-col">
    <x-forms.sub-title>
        <x-slot:title>
            <x-svg.calendar-days-solid color="fill-green-600" size="6" padding="mb-2"/>
            @if($old)
                Previous schedules of the day <span class="text-base">(if available)</span>
            @else
                The schedules of the day
            @endif
        </x-slot:title>
        <div class="my-4">
            @foreach ($date->events as $event)
                @if($old)
                    @if($event->games()->count())
                        <div class="flex justify-center">
                            <a
                                href="{{ route('schedule.event', ['event' => $event]) }}"
                                class="text-blue-800 link"
                                wire:navigate
                            >
                                {{ $event->team_1->name }} - {{ $event->team_2->name }} @json($event->games()->count())
                            </a>
                        </div>
                    @endif
                @else
                    <div class="flex flex-row justify-center space-x-4">
                        <a
                            href="{{ route('schedule.event', ['event' => $event]) }}"
                            class="text-blue-800 link"
                            wire:navigate
                        >
                            {{ $event->team_1->name }} - {{ $event->team_2->name }}
                        </a>
                        <span class="italic text-gray-600">({{ trans_choice('plural.day-games', $event->games()->count()) }})</span>
                    </div>
                @endif
            @endforeach
        </div>
    </x-forms.sub-title>
</div>

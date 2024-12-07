@props(['events', 'dates', 'last_date'])

<div class="block text-lg text-blue-900 ml-4">
    Working on {{ $last_date->date->format('Y-m-d') }}
    @if($last_date->title)
        <div class="inline-block text-teal-700 ml-4">{{ $last_date->title }}</div>
    @endif
</div>

<div class="flex flex-col">
    @forelse($events as $event)

        <div class="inline-block" wire:key="event-{{ $event->id }}">
            @if ($event->date->date->isAfter(now()))
                <img
                    class="inline-block cursor-pointer mr-2"
                    src="{{ secure_asset('svg/minus-box-fill.svg') }}"
                    alt="Remove"
                    width="20"
                    height="20"
                    wire:click="removeEvent({{ $event->id }})"
                >
            @endif
            {{ $event->team_1->name }} - {{ $event->team_2->name }}
            @if ($event->hasScore())
                <span class="text-sm text-gray-600">({{ $event->score1 }} - {{ $event->score2 }})</span>
            @endif
        </div>

    @empty

        <div class="inline-block p-4 ml-4">
            (no games yet)
            <div class="block mt-4">
                <img
                    class="inline-block button cursor-pointer px-2"
                    src="{{ secure_asset('svg/delete-item.svg') }}"
                    alt="Delete this date"
                    width="35"
                    height="35"
                    wire:click="removeDate({{ $last_date->id }})"
                    wire:confirm="Delete this date?"
                > <span class="inline-block text-red-700">Delete this date</span>
            </div>
        </div>
    @endforelse
</div>

<div class="text-xl text-center cursor-pointer my-4 border-2 border-green-500 rounded-xl p-2" wire:click="addNextWeek">
    <img class="mx-auto inline-block mb-1" src="{{ secure_asset('svg/plus-box-fill.svg') }}" alt="" width="20" height="20">
    <div class="text-green-700 inline-block">Add next week</div>
</div>


@forelse($dates as $date)
    <div class="block text-lg" wire:key="date-{{ $date->id }}">
        <div class="inline-block text-green-700 ml-4 cursor-pointer" wire:click="selectedDate({{ $date->id }})">
            {{ $date->date->format('Y-m-d') }}
        </div>

        @if($date->title)
            <div class="inline-block text-teal-700 ml-4">{{ $date->title }}</div>
        @endif
    </div>

    <div class="flex flex-col mb-4">
        @forelse($date->events as $event)
            <div class="inline-block" wire:key="date-event-{{ $event->id }}">
                @if (!$event->hasScore() && $event->date->date->isAfter(now()))
                    <img
                        class="inline-block cursor-pointer mr-2"
                        src="{{ secure_asset('svg/minus-box-fill.svg') }}"
                        alt="Remove"
                        width="20"
                        height="20"
                        wire:confirm="Can be done, but please confirm. Not on a selected date."
                        wire:click="removeEvent({{ $event->id }})"
                    >
                @endif
                {{ $event->team_1->name }} - {{ $event->team_2->name }}
                @if ($event->hasScore())
                    <span class="text-sm text-gray-600">({{ $event->score1 }} - {{ $event->score2 }})</span>
                @endif
            </div>
        @empty
            <div class="inline-block">
                (no games yet)
                <img
                    class="inline-block button cursor-pointer px-2"
                    src="{{ secure_asset('svg/delete-item.svg') }}"
                    alt="Delete this date"
                    width="35"
                    height="35"
                    wire:click="removeDate({{ $date->id }})"
                    wire:confirm="Delete this date?"
                >
            </div>
        @endforelse
    </div>
@empty
    <div class="inline-block">No dates and games available yet</div>
@endforelse

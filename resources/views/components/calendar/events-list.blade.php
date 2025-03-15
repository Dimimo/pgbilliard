@props(['events', 'dates', 'last_date'])

<div>
    <div class="ml-4 block text-lg text-blue-900">
        Working on {{ $last_date->date->appTimezone()->format('Y-m-d') }}
        @if($last_date->title)
            <div class="ml-4 inline-block text-teal-700">{{ $last_date->title }}</div>
        @endif
    </div>

    <div class="flex flex-col">
        @forelse($events as $event)

            <div class="inline-block" wire:key="event-{{ $event->id }}">
                @if ($event->date->date->isAfter(now()->appTimezone()) || !$event->hasScore())
                    <button
                        class="inline-block cursor-pointer"
                        wire:click="removeEvent({{ $event->id }})"
                    >
                        <x-svg.square-minus-solid color="fill-orange-400" size="4" padding="mb-1"/>
                    </button>
                @endif
                {{ $event->team_1->name }} - {{ $event->team_2->name }}
                @if ($event->hasScore())
                    <span class="text-sm text-gray-600">({{ $event->score1 }} - {{ $event->score2 }})</span>
                @endif
            </div>

        @empty
            @php $message = $dates->count() === 1 ? 'Delete this SEASON?' : 'Delete this date?'; @endphp
            <div class="ml-4 inline-block p-4">
                (no games yet)
                <button
                    class="mt-4 cursor-pointer text-red-700"
                >
                    <x-svg.trash-can-solid color="fill-red-600" size="4" padding="mb-1"/> {{ $message }}
                </button>
            </div>
        @endforelse
    </div>

    <div
        class="my-4 cursor-pointer rounded-xl border-2 border-green-500 p-2 text-center text-xl text-green-600"
        wire:click="addNextWeek"
    >
        <x-svg.square-plus-solid color="fill-green-600" size="5" padding="mb-1"/> Add next week
    </div>


    @forelse($dates as $date)
        <div class="block text-lg" wire:key="date-{{ $date->id }}">
            <div class="ml-4 inline-block cursor-pointer text-green-700" wire:click="selectedDate({{ $date->id }})">
                {{ $date->date->format('Y-m-d') }}
            </div>

            @if($date->title)
                <div class="ml-4 inline-block text-teal-700">{{ $date->title }}</div>
            @endif
        </div>

        <div class="mb-4 flex flex-col">
            @forelse($date->events as $event)
                <div class="inline-block" wire:key="date-event-{{ $event->id }}">
                    @if (!$event->hasScore() || $event->date->date->isAfter(now()))
                        <button
                            class="inline-block cursor-pointer"
                            wire:confirm="Can be done, but please confirm. Not on a selected date."
                            wire:click="removeEvent({{ $event->id }})"
                        >
                            <x-svg.square-minus-solid color="fill-orange-400" size="4" padding="mb-1"/>
                        </button>
                    @endif
                    {{ $event->team_1->name }} - {{ $event->team_2->name }}
                    @if ($event->hasScore())
                        <span class="text-sm text-gray-600">({{ $event->score1 }} - {{ $event->score2 }})</span>
                    @endif
                </div>
            @empty
                <button
                    class="inline-block cursor-pointer"
                    wire:click="removeDate({{ $date->id }})"
                    wire:confirm="Delete this date?"
                >
                    (no games yet)
                    <x-svg.trash-can-solid color="fill-red-600" size="4" padding="mb-1"/>
                </button>
            @endforelse
        </div>
    @empty
        <div class="inline-block">No dates and games available yet</div>
    @endforelse
</div>

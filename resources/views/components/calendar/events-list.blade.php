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
                    <img
                        class="mr-2 inline-block cursor-pointer"
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
            @php $message = $dates->count() === 1 ? 'Delete this SEASON?' : 'Delete this date?'; @endphp
            <div class="ml-4 inline-block p-4">
                (no games yet)
                <div class="mt-4 block">
                    <img
                        class="inline-block cursor-pointer px-2 button"
                        src="{{ secure_asset('svg/delete-item.svg') }}"
                        alt="{{ $message }}"
                        width="35"
                        height="35"
                        wire:click="removeDate({{ $last_date->id }})"
                        wire:confirm="{{ $message }}"
                    > <span class="inline-block text-red-700">
                    {{ $message }}
                </span>
                </div>
            </div>
        @endforelse
    </div>

    <div class="my-4 cursor-pointer rounded-xl border-2 border-green-500 p-2 text-center text-xl" wire:click="addNextWeek">
        <img class="mx-auto mb-1 inline-block" src="{{ secure_asset('svg/plus-box-fill.svg') }}" alt="" width="20" height="20">
        <div class="inline-block text-green-700">Add next week</div>
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
                    @if (!$event->hasScore() && $event->date->date->isAfter(now()))
                        <img
                            class="mr-2 inline-block cursor-pointer"
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
                        class="inline-block cursor-pointer px-2 button"
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
</div>

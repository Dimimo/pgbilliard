@props(['events', 'dates', 'last_date'])

<div class="block text-lg text-blue-700 ml-4">{{ $last_date->date->format('Y-m-d') }}</div>
<div class="flex flex-col">
    @forelse($events as $event)
        <div class="inline-block">
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
        </div>
    @empty
        <div class="inline-block">(no games yet)</div>
    @endforelse
</div>

<div class="text-xl cursor-pointer my-4" wire:click="addNextWeek">
    <img class="mx-auto inline-block mb-1" src="{{ secure_asset('svg/plus-box-fill.svg') }}" alt="" width="20" height="20">
    <div class="text-green-700 inline-block">Add next week</div>
</div>


@forelse($dates as $date)
    @if($date->id !== $last_date->id)
        <div class="block text-lg text-green-700 ml-4">{{ $date->date->format('Y-m-d') }}</div>
        <div class="flex flex-col mb-4">
            @forelse($date->events as $event)
                <div class="inline-block">
                    {{ $event->team_1->name }} - {{ $event->team_2->name }}
                </div>
            @empty
                <div class="inline-block">(no games yet)</div>
            @endforelse
        </div>
    @endif
@empty
    <div class="inline-block">No dates and games available yet</div>
@endforelse

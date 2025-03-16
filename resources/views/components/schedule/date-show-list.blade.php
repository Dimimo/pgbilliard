@props(['date', 'old' => false])

<div class="flex justify-center whitespace-nowrap">
    <div class="flex max-w-min flex-col">
        <x-forms.sub-title>
            <x-slot:title>
                <div class="px-4 py-2">
                    <x-svg.calendar-days-solid color="fill-green-600" size="6" padding="mb-2"/>
                    @if($old)
                        @if($date->date->isFuture())
                            {{__('Upcoming schedules')}}
                        @else
                            {{__('Previous schedules')}} <span class="text-base italic">({{__('if available')}})</span>
                        @endif
                    @else
                    {{__('Schedules of the day')}}
                    @endif
                </div>
            </x-slot:title>

            <div class="m-4">
                @foreach ($date->events()->with('games')->get() as $event)
                    @if($old)
                        @if($event->confirmed)
                            <div class="flex justify-center space-x-2">
                                <a
                                    href="{{ route('schedule.event', ['event' => $event]) }}"
                                    class="text-blue-800 link"
                                    wire:navigate
                                >
                                    {{ $event->team_1->name }} - {{ $event->team_2->name }}
                                </a>
                                <span class="italic text-gray-600">
                                    ({{__('finished')}})
                                </span>
                            </div>
                        @else
                            <div class="flex justify-center space-x-2">
                                <span>{{__('No day schedule for')}}</span>
                                <span class="font-bold">
                                    {{ $event->team_1->name }} - {{ $event->team_2->name }}
                                </span>
                            </div>
                        @endif
                    @else
                        @can('update', $event)
                            <x-schedule.schedule-running :event="$event"/>
                        @else
                            @if($event->games()->count())
                                <x-schedule.schedule-running :event="$event"/>
                            @endif
                        @endcan
                    @endif
                @endforeach
            </div>
        </x-forms.sub-title>
    </div>
</div>


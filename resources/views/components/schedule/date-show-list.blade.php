@props(['date', 'old' => false])

<div class="flex justify-center whitespace-nowrap">
    <div class="flex max-w-min flex-col">
        <x-forms.sub-title>
            <x-slot:title>
                <div class="px-4 py-2">
                    @if($old)
                        @if($date->date->isFuture())
                            {{__('Upcoming schedules')}}
                        @else
                            <div>{{__('Previous schedules')}}</div>
                            <div class="text-center text-base italic">({{__('if available')}})</div>
                        @endif
                    @else
                        {{__('Schedules of the day')}}
                    @endif
                </div>
            </x-slot:title>

            <div class="m-4">
                @foreach ($date->events()->with('games')->get() as $event)
                    @if($event->team_2->name !== 'BYE')

                        <div wire:key="event-list-{{ $event->id }}">
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
                                @elseif($event->date->date->isFuture())
                                    <div class="flex justify-center space-x-2">
                                        <span>{{__('Planned game for')}}</span>
                                        <span class="font-bold">
                                    {{ $event->team_1->name }} - {{ $event->team_2->name }}
                                </span>
                                    </div>
                                @else
                                    <div class="flex flex-row justify-center space-x-2">
                                        <div>{{__('No schedule available for')}}</div>
                                        <div class="font-bold">
                                            {{ $event->team_1->name }} - {{ $event->team_2->name }}
                                        </div>
                                    </div>

                                @endif
                            @else
                                @can('update', $event)
                                    <x-schedule.schedule-running
                                        key="date-list-{{$event->id}}"
                                        :event="$event"
                                        :can_update="true"
                                    />
                                @else
                                    @if($event->games()->whereNotNull('win')->count())
                                        <x-schedule.schedule-running
                                            key="date-list-{{$event->id}}"
                                            :event="$event"
                                            :available="true"
                                            :can_update="false"
                                        />
                                    @else
                                        <x-schedule.schedule-running
                                            key="date-list-{{$event->id}}"
                                            :event="$event"
                                            :available="false"
                                            :can_update="false"
                                        />
                                    @endif
                                @endcan
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </x-forms.sub-title>
    </div>
</div>


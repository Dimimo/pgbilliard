<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

state('event');
name('schedule.event');
?>

<x-layout>
    @volt
    <section>
        <x-title help="schedule">
            <x-slot:title>
                {{__('The daily games of')}} <span class="font-bold">{{ $event->team_1->name }} - {{ $event->team_2->name }}</span>
            </x-slot:title>

            <x-slot:subtitle>
                <div>{{__('on the')}} {{ $event->date->date->format('jS \o\f M Y') }}</div>
                @if ($event->confirmed)
                    <div class="mt-4 text-gray-600">
                        <span @class(['text-green-700 text-2xl' => $event->score1 > 7])>{{ $event->team_1->name }} {{ $event->score1 }}</span>
                        <x-svg.minus-solid color="fill-gray-600" size="3" padding="mx-2"/>
                        <span @class(['text-green-700 text-2xl' => $event->score2 > 7])>{{ $event->score2 }} {{ $event->team_2->name }}</span>
                    </div>
                @endif
            </x-slot:subtitle>
        </x-title>

        <livewire:date.schedule key="date-event-{{$event->id}}" :event="$event"/>

    </section>
    @endvolt
</x-layout>

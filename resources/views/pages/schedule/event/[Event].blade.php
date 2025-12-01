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
            @if (session('is_android', false))
                <x-navigation.main-links-buttons />
            @endif

            <x-title help="schedule">
                <x-slot:title>
                    {{ __('The daily games of') }}
                    <span class="font-bold">
                        {{ $event->team_1->name }} - {{ $event->team_2->name }}
                    </span>
                </x-slot>

                <x-slot:subtitle>
                    <div>{{ __('on the') }} {{ $event->date->date->format('jS \o\f M Y') }}</div>
                    @if ($event->confirmed)
                        <div class="mt-4 text-gray-600">
                            <span @class(['text-2xl text-green-700' => $event->score1 > 7])>
                                {{ $event->team_1->name }} {{ $event->score1 }}
                            </span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 448 512"
                                class="mx-2 inline-block h-3 w-3 fill-gray-600"
                            >
                                <path
                                    d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"
                                />
                            </svg>
                            <span @class(['text-2xl text-green-700' => $event->score2 > 7])>
                                {{ $event->score2 }} {{ $event->team_2->name }}
                            </span>
                        </div>
                    @endif
                </x-slot>
            </x-title>

            <livewire:date.schedule key="date-event-{{ $event->id }}" :event="$event" />
        </section>
    @endvolt
</x-layout>

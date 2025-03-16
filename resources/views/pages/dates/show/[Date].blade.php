<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

state('date');
name('dates.show');
?>

<x-layout title="{{__('Day Scores and Game details')}}">
    @volt
    <section>
        <x-title
            title="Update the scores of the {{ $date->date->format('jS \o\f M Y') }}"
            subtitle="{{__('Season')}} {{ session('cycle') }}"
            help="live-scores"
        />
        <div class="grid justify-items-center">
            <table class="mb-4 min-w-full border-2 border-gray-900 bg-transparent table-collapse md:min-w-0">
                <thead class="whitespace-nowrap border-2 border-gray-900 bg-gray-300">
                <tr class="py-2">
                    <th class="p-2 text-left">{{__('Home')}}</th>
                    <th class="p-2 text-center" colspan="2">
                        <div class="flex items-center justify-center">
                            <div class="inline-block">{{__('Scores')}}</div>
                            <div class="-mb-1 inline-block">
                                <x-forms.spinner/>
                            </div>
                            <div class="ml-2 inline-block">
                                <x-forms.action-message class="font-semibold text-green-700" on="scores-updated">
                                    {{__('Updated')}}
                                </x-forms.action-message>
                                <x-forms.action-message class="font-bold text-green-700" on="score-confirmed">
                                    {{__('Confirmed')}}
                                </x-forms.action-message>
                            </div>
                        </div>
                    </th>
                    <th class="p-2 text-left">{{__('Visitors')}}</th>
                    <th class="w-28 p-2 text-left"></th>
                </tr>
                </thead>
                @foreach ($date->events as $event)
                    <livewire:date.update :event="$event" :key="$event->id"/>
                @endforeach
            </table>
        </div>

        @if(session('is_admin') || $date->checkOpenWindowAccess())
            <x-schedule.date-show-list :date="$date"/>
        @elseif($date->throughEvents()->hasGames()->count())
            <x-schedule.date-show-list :date="$date" :old="true"/>
        @endif

        @if (app()->isProduction())
            @script
            <script>
                window.Echo.channel('live-score');
            </script>
            @endscript
        @endif

    </section>
    @endvolt
</x-layout>

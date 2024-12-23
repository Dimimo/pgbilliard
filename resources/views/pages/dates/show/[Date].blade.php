<?php

use App\Livewire\WithCurrentCycle;
use App\Livewire\WithHasAccess;
use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

uses([WithHasAccess::class, WithCurrentCycle::class]);
state('date');
name('dates.show');
?>

<x-layout>
    @volt
    <section>
        <x-title
            title="Update the scores of the {{ $date->date->format('jS \o\f M Y') }}"
            subtitle="Season {{ $cycle }}"
        />
        <div class="grid justify-items-center">
            <table class="mb-4 min-w-full border-2 border-gray-900 bg-transparent table-collapse md:min-w-0">
                <thead class="whitespace-nowrap border-2 border-gray-900 bg-gray-300">
                <tr class="py-2">
                    <th class="p-2 text-left">Home</th>
                    <th class="p-2 text-center" colspan="2">
                        <div class="flex justify-center items-center">
                            <div class="inline-block">Scores</div>
                            <div class="-mb-1 inline-block">
                                <x-forms.spinner/>
                            </div>
                            <div class="ml-2 inline-block">
                                <x-forms.action-message class="font-semibold text-green-700" on="scores-updated">
                                    Updated
                                </x-forms.action-message>
                                <x-forms.action-message class="font-bold text-green-700" on="score-confirmed">
                                    Confirmed
                                </x-forms.action-message>
                            </div>
                        </div>
                    </th>
                    <th class="p-2 text-left">Visitors</th>
                    <th class="p-2 text-left w-28"></th>
                </tr>
                </thead>
                @foreach ($date->events as $event)
                    <livewire:date.update :event="$event" :key="$event->id"/>
                @endforeach
            </table>
        </div>
    </section>

    @endvolt
</x-layout>

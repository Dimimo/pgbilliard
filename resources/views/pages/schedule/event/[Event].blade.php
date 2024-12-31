<?php

use App\Livewire\WithCurrentCycle;
use App\Livewire\WithHasAccess;
use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

uses([WithHasAccess::class, WithCurrentCycle::class]);
state('event');
name('schedule.event');
?>

<x-layout>
    @volt
    <section>
        <x-title help="schedule">
            <x-slot:title>
                The schedule of <span class="font-bold">{{ $event->team_1->name }} - {{ $event->team_2->name }}</span>
            </x-slot:title>
            <x-slot:subtitle>
                on the {{ $event->date->date->format('jS \o\f M Y') }}
            </x-slot:subtitle>
        </x-title>
        <livewire:date.schedule :event="$event"/>
    </section>
    @endvolt
</x-layout>

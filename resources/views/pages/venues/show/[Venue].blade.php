<?php

use App\Livewire\WithCurrentCycle;
use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

uses([WithCurrentCycle::class]);
state('venue');
name('venues.show');
?>

<x-layout>
    @volt
    <section>
        <x-title
            title="Details of the venue <strong>{{ $venue->name }}</strong>"
            subtitle="Season {{ $cycle }}"
        />
        <livewire:venue :venue="$venue" :title="$venue->name"/>

        @foreach($venue->teams->where('season_id', $season->id)->sortBy('name') as $team)
            <x-forms.sub-title title="Team {{ $team->name }}">
                <livewire:players.overview :team="$team"/>
            </x-forms.sub-title>
        @endforeach
    </section>
    @endvolt
</x-layout>

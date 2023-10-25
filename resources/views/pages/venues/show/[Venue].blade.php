<?php

use App\Livewire\WithCurrentCycle;
use App\Taps\Cycle;
use function Livewire\Volt\computed;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

uses([WithCurrentCycle::class]);
state(['venue' => fn() => $venue]);
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
            <x-sub-title title="Team {{ $team->name }}">
                <livewire:players.overview :team="$team"/>
            </x-sub-title>
        @endforeach
    </section>
    @endvolt
</x-layout>

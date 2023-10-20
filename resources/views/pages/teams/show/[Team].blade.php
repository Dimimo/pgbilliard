<?php

use function Livewire\Volt\
{state
};

state(['team' => fn() => $team]);
?>
<x-layout>
    @volt
    <div>
        <x-sub-title title="Details of <strong>{{ $team->name }}</strong>">
            <livewire:venue :venue="$team->venue"/>
        </x-sub-title>

        <x-sub-title title="Players">
            <livewire:players.overview :team="$team"/>
        </x-sub-title>

        <x-sub-title title="The playing schedule of {{ $team->name }}">
            <livewire:players.schedule :team="$team"/>
        </x-sub-title>
    </div>
    @endvolt
</x-layout>

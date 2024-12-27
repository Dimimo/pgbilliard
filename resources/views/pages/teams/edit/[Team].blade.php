<?php

use App\Livewire\WithCurrentCycle;
use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

uses([WithCurrentCycle::class]);
state('team');
name('teams.edit');
?>

<x-layout>
    @volt
    <section>
        <x-title
            title="Edit the team <strong>{{$team->name}}</strong>"
            subtitle="Season {{ $cycle }}"
            help="teams"
        />

        @can('update', $team)
            @can('create', $team)
                <livewire:team.edit :team="$team"/>
            @else
                <livewire:venue :venue="$team->venue"/>
            @endcan

            <livewire:players.edit :team="$team"/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan

    </section>
    @endvolt
</x-layout>

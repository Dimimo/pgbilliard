<?php

use App\Livewire\WithCurrentCycle;
use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

state('team');
name('teams.edit');
?>

<x-layout>
    @volt
        <section>
            <x-title
                title="{{__('Edit the team')}} <strong>{{$team->name}}</strong>"
                subtitle="{{__('Season')}} {{ session('cycle') }}"
                help="teams"
            />

            @can('update', $team)
                @can('create', $team)
                    <livewire:team.edit :team="$team" />
                @else
                    <livewire:venue :venue="$team->venue" />
                @endcan

                <livewire:players.edit :team="$team" />
            @else
                <div class="text-xl text-red-700">
                    {{ __("You don't have access to this page") }}
                </div>
            @endcan
        </section>
    @endvolt
</x-layout>

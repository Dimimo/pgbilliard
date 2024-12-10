<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

state('team');
name('teams.show');
?>

<x-layout>
    @volt
    <section>
        <x-title title="Details of <strong>{{ $team->name }}</strong>"/>
        <livewire:venue :venue="$team->venue"/>

        <x-forms.sub-title title="Players">
            <livewire:players.overview :team="$team"/>
        </x-forms.sub-title>

        <x-forms.sub-title title="The playing schedule of {{ $team->name }}">
            <livewire:players.schedule :team="$team"/>
        </x-forms.sub-title>
    </section>
    @endvolt
</x-layout>

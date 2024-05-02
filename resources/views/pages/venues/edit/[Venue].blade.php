<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

state('venue');
name('venues.edit');
?>

<x-layout>
    @volt
    <section>
        <x-title title="Edit the venue {{ $venue->name }}"/>
        @can('update', $venue)
            <livewire:admin.venue :venue="$venue"/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan
    </section>
    @endvolt
</x-layout>

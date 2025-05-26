<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('admin.season.update');
state('season');
?>

<x-layout>
    @volt
    <section>
        @can('update', $season)
            <livewire:admin.season.update :season="$season"/>
        @else
            <div class="text-red-700 text-xl">{{__("You don't have access to this page")}}</div>
        @endcan
    </section>
    @endvolt
</x-layout>

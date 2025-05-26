<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('admin.calendar.update');
state('season');
?>
<x-layout>
    @volt
    <section>
        <x-title title="Update the calendar for season {{ $season->cycle }}"/>
        @can('update', \App\Models\Date::class)
            <livewire:admin.calendar.create :season="$season"/>
        @else
            <div class="text-red-700 text-xl">{{__("You don't have access to this page")}}</div>
        @endcan
    </section>
    @endvolt
</x-layout>

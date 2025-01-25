<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('admin.calendar.shift');
state('season');
?>
<x-layout>
    @volt
    <section>
        <x-title title="Shift a date for season {{ $season->cycle }}"/>
        @can('update', \App\Models\Date::class)
            <livewire:admin.calendar.shift :season="$season"/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan
    </section>
    @endvolt
</x-layout>


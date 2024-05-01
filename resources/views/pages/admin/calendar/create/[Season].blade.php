<?php

use function Livewire\Volt\state;

state(['season' => fn() => $season]);
?>
<x-layout>
    @volt
    <section>
        <x-title title="Create the calendar for season {{ $season->cycle }}"/>
        @can('create', \App\Models\Date::class)
            <livewire:admin.calendar.create :season="$season"/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan
    </section>
    @endvolt
</x-layout>

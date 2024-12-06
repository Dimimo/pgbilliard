<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('admin.season.update');
state('season');
?>

<x-layout>
    @volt
    <section>
        @can('create', \App\Models\Team::class)
            <livewire:admin.teams.create :season="$season"/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan
    </section>
    @endvolt
</x-layout>

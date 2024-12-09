<?php

use function Laravel\Folio\name;

name('admin.schedule.create');
?>
<x-layout>
    @volt
    <section>
        <x-title title="Create a new Day Schedule"/>
        @can('create', \App\Models\Schedule::class)
            <livewire:admin.schedule.create/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan
    </section>
    @endvolt
</x-layout>

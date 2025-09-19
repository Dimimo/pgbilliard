<?php

use function Laravel\Folio\name;

name('admin.schedule.index')

?>

<x-layout>
    @volt
        <section>
            <x-title title="Overview of Day Schedules" />
            @can('create', \App\Models\Schedule::class)
                <livewire:admin.schedule.index />
            @else
                <div class="text-xl text-red-700">
                    {{ __("You don't have access to this page") }}
                </div>
            @endcan
        </section>
    @endvolt
</x-layout>

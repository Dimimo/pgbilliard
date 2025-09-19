<?php

use function Laravel\Folio\name;

name('admin.schedule.create');
?>

<x-layout>
    @volt
        <section>
            <x-title title="Create a new Day Schedule" />
            @can('create', \App\Models\Schedule::class)
                <livewire:admin.schedule.create />
            @else
                <div class="text-xl text-red-700">
                    {{ __("You don't have access to this page") }}
                </div>
            @endcan
        </section>
    @endvolt
</x-layout>

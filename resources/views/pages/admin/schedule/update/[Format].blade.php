<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('admin.schedule.update');
state('format');
?>
<x-layout>
    @volt
    <section>
        <x-title title="Update a the Day Schedule '{{ $format->name }}'"/>
        @can('update', $format)
            <livewire:admin.schedule.create :format="$format"/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan
    </section>
    @endvolt
</x-layout>

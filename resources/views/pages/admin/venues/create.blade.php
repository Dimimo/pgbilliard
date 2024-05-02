<?php

use App\Models\Venue;
use function Laravel\Folio\name;

name('admin.venues.create');
?>

<x-layout>
    @volt
    <section>
        @can('create', new Venue())
            <x-title title="Create a new venue"/>
            <livewire:admin.venues.create :venue="new \App\Models\Venue(['name' => ''])"/>
        @endcan
    </section>
    @endvolt
</x-layout>

<?php

use function Laravel\Folio\name;

name('admin.overview');
?>

<x-layout>
    @volt
    <section>
        @if (auth()->user()?->isAdmin())
            <x-title title="Overview of all assigned administrators"/>
            <livewire:admin.overview/>
        @endif
    </section>
    @endvolt
</x-layout>

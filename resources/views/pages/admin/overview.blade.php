<?php

use function Laravel\Folio\name;

name('admin.overview');
?>

<x-layout>
    @volt
    <section>
        <x-title title="Overview of all assigned administrators"/>
        <livewire:admin.overview/>
    </section>
    @endvolt
</x-layout>

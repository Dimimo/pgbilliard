<?php

use function Laravel\Folio\name;

name('admin.overview');
?>

<x-layout>
    @volt
    <section>
        <x-title title="Overview of administrators"/>
        <livewire:admin.overview/>
    </section>
    @endvolt
</x-layout>

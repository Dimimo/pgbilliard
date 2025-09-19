<?php

use function Laravel\Folio\name;

name('admin.overview');
?>

<x-layout>
    @volt
        <section>
            @if (session('is_admin'))
                <x-title title="Overview of all assigned administrators" />
                <livewire:admin.overview />
            @endif
        </section>
    @endvolt
</x-layout>

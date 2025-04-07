<?php

use function Laravel\Folio\name;

name('seasons.all');
?>
<x-layout>
    @volt

    <section>
        <x-title>
            <x-slot:title>{{__('All Seasons')}}</x-slot:title>
            <x-slot:subtitle>{{__('Select another Season')}}</x-slot:subtitle>
        </x-title>

        <livewire:cycle-all/>
    </section>

    @endvolt
</x-layout>

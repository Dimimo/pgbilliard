<?php

use function Laravel\Folio\name;

name('calendar');
?>

<x-layout title="The Calendar and Schedule">
    @volt
        <div>
            <livewire:calendar lazy />
        </div>
    @endvolt
</x-layout>

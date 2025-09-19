<?php

use function Laravel\Folio\name;

name('calendar');
?>

<x-layout>
    @volt
        <div>
            <livewire:calendar />
        </div>
    @endvolt
</x-layout>

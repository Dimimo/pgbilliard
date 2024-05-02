<?php

use function Laravel\Folio\name;

name('scoresheet');
?>

<x-layout>
    @volt
    <div>
        <livewire:score/>
    </div>
    @endvolt
</x-layout>

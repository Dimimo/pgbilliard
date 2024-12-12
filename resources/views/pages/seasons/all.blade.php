<?php

use function Laravel\Folio\name;
use function Livewire\Volt\uses;

name('seasons.all');
?>
<x-layout>
@volt

<section>
    <x-title>
        <x-slot:title>All seasons</x-slot:title>
        <x-slot:subtitle>Select a season</x-slot:subtitle>
    </x-title>

    <livewire:cycle-all/>
</section>

@endvolt
</x-layout>

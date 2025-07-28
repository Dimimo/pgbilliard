<?php

use function Laravel\Folio\name;

name('scoreboard');
?>

<x-layout title="Scoreboard">
    @volt
    <div>
        <livewire:score/>
        <livewire:rank/>
    </div>
    @endvolt
</x-layout>

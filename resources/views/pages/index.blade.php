<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('scoreboard');
state(['isAndroid' => session('is_android', false)]);
?>

<x-layout title="Scoreboard">
    @volt
        <div>
            <livewire:score :is-android="$isAndroid" lazy />
            <livewire:rank lazy="on-load" />
        </div>
    @endvolt
</x-layout>

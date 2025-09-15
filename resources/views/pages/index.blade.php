<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('scoreboard');
state(['isAndroid' => !session('is_android', false)]);
?>

<x-layout title="Scoreboard">
    @volt
    <div>
        <livewire:score :is-android="$isAndroid"/>
        <livewire:rank/>
    </div>
    @endvolt
</x-layout>

<?php
use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('players.show');
state('player');
?>

<x-layout title="Player details of {{ $player->name }}">
    @volt
    <section>
        <x-title
            title="Personal profile and results of {{ $player->name }}"
            subtitle="Season {{ session('cycle') }}"
        />
        <livewire:players.details :player="$player"/>
    </section>
    @endvolt
</x-layout>

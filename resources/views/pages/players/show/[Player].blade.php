<?php
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('players.show');
state('player');
middleware('season.visible:player,team.season');
?>

<x-layout title="Player details of {{ $player->name }}">
    @volt
        <section>
            <x-title
                title="Personal profile and results of {{ $player->name }}"
                subtitle="Season {{ session('cycle') }}"
            />

            @if (session('is_android', false))
                <x-navigation.main-links-buttons />
            @endif

            <livewire:players.details :player="$player" />
        </section>
    @endvolt
</x-layout>

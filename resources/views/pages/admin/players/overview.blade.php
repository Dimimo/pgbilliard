<?php

use function Laravel\Folio\name;

name('admin.players.overview');
?>

<x-layout title="{{ __('Overview of all players and users') }}">
    @volt
        <section>
            @if (session('is_admin'))
                <x-title
                    :title="__('Overview of all players and users')"
                    :subtitle="__('delete non-active players')"
                />
                <livewire:admin.players.overview />
            @endif
        </section>
    @endvolt
</x-layout>

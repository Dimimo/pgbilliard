<?php

use function Laravel\Folio\name;

name('rank');
?>

<x-layout title="Individual Ranking">
    @volt
        <div>
            <x-title
                title="{{__('The individual ranking overview')}}"
                subtitle="{{__('Season')}} {{ session('cycle') }}"
                help="ranking"
            />

            @if (session('is_android', false))
                <x-navigation.main-links-buttons />
            @endif

            <livewire:rank />
        </div>
    @endvolt
</x-layout>

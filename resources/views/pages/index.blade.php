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
            <div class="mt-12 rounded-lg border-2 border-gray-900 p-4">
                <x-title
                    title="{{__('The individual ranking overview')}}"
                    subtitle="{{__('Season')}} {{ session('cycle') }}"
                    help="ranking"
                    :gradient="false"
                />
                <livewire:rank lazy="on-load" />
            </div>
        </div>
    @endvolt
</x-layout>

<?php

use function Laravel\Folio\name;

name('help.ranking');
?>

<x-layout>
    @volt

    <section>
        <x-title>
            <x-slot:title>{{__('The help pages')}}</x-slot:title>
            <x-slot:subtitle>
                <x-svg.circle-question-solid color="fill-green-600" size="6"/>
                The Individual Ranking Overview
            </x-slot:subtitle>
        </x-title>

        <x-help.ranking/>
    </section>

    @endvolt
</x-layout>

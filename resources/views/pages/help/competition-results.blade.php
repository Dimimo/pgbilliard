<?php

use function Laravel\Folio\name;

name('help.results');
?>
<x-layout>
    @volt

    <section>
        <x-title>
            <x-slot:title>{{__('The help pages')}}</x-slot:title>
            <x-slot:subtitle>
                <x-svg.circle-info-solid color="fill-green-600" size="6"/>
                Scoreboard (Competition results)
            </x-slot:subtitle>
        </x-title>

        <x-help.competition-results/>
    </section>

    @endvolt
</x-layout>

<?php

use function Laravel\Folio\name;

name('help.rules');
?>
<x-layout>
    @volt

    <section>
        <x-title>
            <x-slot:title>{{__('The help pages')}}</x-slot:title>
            <x-slot:subtitle>
                <x-svg.circle-question-solid color="fill-green-600" size="6"/>
                The Rules of the Puerto Galera Billiard League
            </x-slot:subtitle>
        </x-title>

        <x-help.billiard-rules/>
    </section>

    @endvolt
</x-layout>

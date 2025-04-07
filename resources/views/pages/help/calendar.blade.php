<?php

use function Laravel\Folio\name;

name('help.calendar');
?>
<x-layout>
    @volt

    <section>
        <x-title>
            <x-slot:title>{{__('The help pages')}}</x-slot:title>
            <x-slot:subtitle>
                <x-svg.circle-question-solid color="fill-green-600" size="6"/>
                Calendar, Schedule and Results
            </x-slot:subtitle>
        </x-title>

        <x-help.calendar/>
    </section>

    @endvolt
</x-layout>

<?php

use function Laravel\Folio\name;

name('help.schedule');
?>
<x-layout>
    @volt

    <section>
        <x-title>
            <x-slot:title>{{__('The help pages')}}</x-slot:title>
            <x-slot:subtitle>
                <x-svg.circle-question-solid color="fill-green-600" size="6"/>
                the detailed day event schedules and individual scores
            </x-slot:subtitle>
        </x-title>

        <x-help.schedule/>
    </section>

    @endvolt
</x-layout>


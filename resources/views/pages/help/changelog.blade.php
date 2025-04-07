<?php

use function Laravel\Folio\name;

name('help.changelog');
?>
<x-layout>
    @volt

    <section>
        <x-title>
            <x-slot:title>{{__('The help pages')}}</x-slot:title>
            <x-slot:subtitle>
                <x-svg.circle-question-solid color="fill-green-600" size="6"/>
                {{ __('Changelog') }}
            </x-slot:subtitle>
        </x-title>

        <x-help.changelog/>
    </section>

    @endvolt
</x-layout>

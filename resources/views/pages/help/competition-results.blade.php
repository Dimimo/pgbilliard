<?php

use function Laravel\Folio\name;

name('help.results');
?>
<x-layout>
    @volt

    <section>
        <x-title>
            <x-slot:title>The help pages</x-slot:title>
            <x-slot:subtitle>
                <x-svg.circle-question-solid color="fill-green-600" size="7"/>
                Scoresheet (Competition results)
            </x-slot:subtitle>
        </x-title>

        <x-help.competition-results/>
    </section>

    @endvolt
</x-layout>

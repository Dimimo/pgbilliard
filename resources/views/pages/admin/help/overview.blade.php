<?php

use function Laravel\Folio\name;

name('admin.help.overview');
?>
<x-layout>
    @volt
    <section>
        @if (auth()->user()?->isAdmin())
            <x-title>
                <x-slot:title>The admin help pages</x-slot:title>
                <x-slot:subtitle>
                    <x-svg.circle-info-solid color="fill-green-600" size="6" padding=""/>
                    overview and vision
                </x-slot:subtitle>
            </x-title>
            <x-admin.help.overview/>
        @endif
    </section>
    @endvolt
</x-layout>


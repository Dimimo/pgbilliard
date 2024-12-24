<?php

use function Laravel\Folio\name;

name('admin.help.schedule');
?>
<x-layout>
    @volt
    <section>
        @if (auth()->user()?->isAdmin())
            <x-title>
                <x-slot:title>The admin help pages</x-slot:title>
                <x-slot:subtitle>
                    <x-svg.circle-info-solid color="fill-green-600" size="6" padding=""/>
                    day schedule blueprint
                </x-slot:subtitle>
            </x-title>
            <x-admin.help.day-schedule/>
        @endif
    </section>
    @endvolt
</x-layout>

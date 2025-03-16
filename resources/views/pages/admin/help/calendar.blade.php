<?php

use App\Livewire\WithCurrentCycle;
use function Laravel\Folio\name;
use function Livewire\Volt\uses;

uses(WithCurrentCycle::class);
name('admin.help.calendar');

?>
<x-layout>
    @volt
    <section>
        @if (session('is_admin'))
            <x-title>
                <x-slot:title>The admin help pages</x-slot:title>
                <x-slot:subtitle>
                    <x-svg.circle-info-solid color="fill-green-600" size="6" padding=""/>
                    calendar creation and update
                </x-slot:subtitle>
            </x-title>
            <x-admin.help.calendar :new="true" :dates="$season->dates"/>
        @endif
    </section>
    @endvolt
</x-layout>

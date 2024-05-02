<?php

use App\Livewire\WithCurrentCycle;
use App\Livewire\WithHasAccess;
use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

uses([WithHasAccess::class, WithCurrentCycle::class]);
state('date');
name('dates.show');
?>

<x-layout>
    @volt
    <section>
        <x-title
            title="Update the scores of the {{ $date->date->format('jS \o\f M Y') }}"
            subtitle="Season {{ $cycle }}"
        />
        @if($hasAccess || $date->checkIfGuestHasWritableAccess())
            <livewire:date.update :date="$date"/>
        @else
            <div class="text-red-700 text-xl">You have currently no access to this page, please contact an administrator if you need a score updated.</div>
        @endif
    </section>

    @endvolt
</x-layout>

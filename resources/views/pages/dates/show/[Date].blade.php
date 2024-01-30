<?php

use function Livewire\Volt\state;
use function Livewire\Volt\uses;

uses([\App\Livewire\WithHasAccess::class, \App\Livewire\WithCurrentCycle::class]);
state(['date' => fn() => $date]);
?>

<x-layout>
    @volt
    <section>
        <x-title
            title="Update the scores of the {{ $date->date->format('jS \o\f M Y') }}"
            subtitle="Season {{ $cycle }}"
        />
        @if($hasAccess || $date->checkIfGuestHasWritableAccess())
            <livewire:date.update :date="$date" />
        @else
            <div class="text-red-700 text-xl">You have currently no access to this page, please text Richard if you need a score updated.</div>
        @endif
    </section>

    @endvolt
</x-layout>

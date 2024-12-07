<?php

use App\Livewire\WithCurrentCycle;
use App\Livewire\WithHasAccess;
use function Laravel\Folio\name;
use function Livewire\Volt\uses;

uses([WithHasAccess::class, WithCurrentCycle::class]);
name('season.select');
?>
<x-layout>
    @volt

    <section>
        @dd($season)
    </section>

    @endvolt
</x-layout>

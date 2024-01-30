<?php

use function Livewire\Volt\uses;
use App\Livewire\WithCurrentCycle;

uses([WithCurrentCycle::class]);
?>
<x-layout>
    @volt
    <section>
        <x-title title="The Administration menu"/>
        <div class="flex flex-col">
            <x-nav-link href="/admin/venues/create" class="flex justify-center text-xl" :active="false">
                Create a new Venue
            </x-nav-link>
            <x-nav-link href="/admin/season/create" class="flex justify-center text-xl" :active="false">
                Create a new Season
            </x-nav-link>
            <x-nav-link href="/admin/overview" class="flex justify-center text-xl" :active="false">
                Overview of all administrators
            </x-nav-link>
            <div class="m-2 p-2 border border-blue-600 border-2 rounded">
                <x-nav-link href="/admin/calendar/update/{{ $season->id }}" class="flex justify-center text-xl" :active="false">
                    Update the current Calendar ({{ $cycle }})
                </x-nav-link>
            </div>
        </div>
    </section>
    @endvolt
</x-layout>

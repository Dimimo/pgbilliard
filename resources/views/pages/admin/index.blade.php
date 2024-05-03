<?php

use function Livewire\Volt\uses;
use function Laravel\Folio\name;
use App\Livewire\WithCurrentCycle;

name('admin.index');

uses([WithCurrentCycle::class]);
?>
<x-layout>
    @volt
    <section>
        <x-title title="The Administration menu"/>
        <div class="flex flex-col">
            <x-nav-link href="{{ route('admin.venues.create') }}" class="flex justify-center mx-auto text-xl" :active="false" wire:navigate>
                Create a new Venue
            </x-nav-link>
            <x-nav-link href="{{ route('admin.seasons.create') }}/admin/season/create" class="flex justify-center mx-auto text-xl" :active="false" wire:navigate>
                Create a new Season
            </x-nav-link>
            <x-nav-link href="{{ route('admin.overview') }}" class="flex justify-center mx-auto text-xl" :active="false">
                Overview of all administrators
            </x-nav-link>
            <div class="flex justify-center m-2 p-2 border-blue-600 border-2 rounded">
                <x-nav-link href="{{ route('admin.calendar.update', ['season' => $season]) }}" class="flex justify-center mx-auto text-xl" :active="false" wire:navigate>
                    Update the current Calendar ({{ $cycle }})
                </x-nav-link>
            </div>
        </div>
    </section>
    @endvolt
</x-layout>

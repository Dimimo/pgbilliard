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
            <x-nav-link
                href="{{ route('admin.venues.create') }}"
                class="flex justify-center mx-auto text-xl" :active="false"
                wire:navigate
            >
                Create a new Venue
            </x-nav-link>
            <x-nav-link
                href="{{ route('admin.seasons.create') }}"
                class="flex justify-center mx-auto text-xl"
                :active="false"
                wire:navigate
            >
                Create a new Season
            </x-nav-link>
            <x-nav-link
                href="{{ route('admin.overview') }}"
                class="flex justify-center mx-auto text-xl"
                :active="false"
                wire:navigate
            >
                Overview of all Administrators
            </x-nav-link>
            <div class="m-2 p-2 w-auto border-blue-600 border-2 rounded-xl">
                <div class="flex justify-center">
                    <x-nav-link
                        href="{{ route('admin.calendar.update', ['season' => $season]) }}"
                        class="text-center mx-auto text-xl"
                        :active="false"
                        wire:navigate
                    >
                        Update the current Calendar ({{ $cycle }})
                    </x-nav-link>
                </div>
                <div class="flex justify-center">
                    <x-nav-link
                        href="{{ route('admin.teams.create', ['season' => $season]) }}"
                        class="text-center mx-auto text-xl"
                        :active="false"
                        wire:navigate
                    >
                        Update or create teams, their venue and captain, add or remove a BYE ({{ $cycle }})
                    </x-nav-link>
                </div>
            </div>
        </div>
    </section>
    @endvolt
</x-layout>

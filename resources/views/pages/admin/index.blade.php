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
            <x-title title="The Administration menu" />

            <div class="my-8 border border-green-500 bg-green-50 p-4">
                <x-admin.help.overview />
            </div>

            <div class="flex flex-col">
                <x-forms.nav-link
                    href="{{ route('admin.venues.create') }}"
                    class="mx-auto flex justify-center text-xl"
                    :active="false"
                    wire:navigate
                >
                    {{ __('Create a new Venue') }}
                </x-forms.nav-link>
                <x-forms.nav-link
                    href="{{ route('admin.seasons.create') }}"
                    class="mx-auto flex justify-center text-xl"
                    :active="false"
                    wire:navigate
                >
                    {{ __('Create a new Season') }}
                </x-forms.nav-link>
                <x-forms.nav-link
                    :href="route('admin.schedule.index')"
                    class="mx-auto flex justify-center text-xl"
                    wire:navigate
                >
                    {{ __('Day Schedules') }}
                </x-forms.nav-link>
                <x-forms.nav-link
                    href="{{ route('admin.overview') }}"
                    class="mx-auto flex justify-center text-xl"
                    :active="false"
                    wire:navigate
                >
                    {{ __('List of Administrators') }}
                </x-forms.nav-link>
                <x-forms.nav-link
                    href="{{ route('logs') }}"
                    class="mx-auto flex justify-center text-xl"
                    :active="false"
                    wire:navigate
                >
                    {{ __('The log file of all score changes') }}
                </x-forms.nav-link>

                <div class="m-2 w-auto rounded-xl border-2 border-blue-600 p-2">
                    <div class="flex flex-col justify-center">
                        <x-forms.nav-link
                            :href="route('admin.season.update', ['season' => $season])"
                            class="mx-auto text-center text-xl"
                            :active="false"
                            wire:navigate
                        >
                            {{ __('Update Season structure') }}
                        </x-forms.nav-link>
                        <x-forms.nav-link
                            href="{{ route('admin.calendar.update', ['season' => $season]) }}"
                            class="mx-auto text-center text-xl"
                            :active="false"
                            wire:navigate
                        >
                            {{ __('Update the current Calendar') }}
                        </x-forms.nav-link>
                        <x-forms.nav-link
                            href="{{ route('admin.season.update', ['season' => $season]) }}"
                            class="mx-auto text-center text-xl"
                            :active="false"
                            wire:navigate
                        >
                            {{ __('Update the Season structure') }}
                        </x-forms.nav-link>
                    </div>
                </div>
            </div>
        </section>
    @endvolt
</x-layout>

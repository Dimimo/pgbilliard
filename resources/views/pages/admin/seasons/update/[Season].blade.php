<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('admin.seasons.update');
state('season');
?>

<x-layout>
    @volt
        <section>
            @can('update', $season)
                <livewire:admin.seasons.update :season="$season" />
            @else
                <div class="text-xl text-red-700">
                    {{ __("You don't have access to this page") }}
                </div>
            @endcan
        </section>
    @endvolt
</x-layout>

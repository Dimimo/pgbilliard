<?php

use App\Models\Season;
use function Laravel\Folio\name;

name('admin.seasons.create');
?>

<x-layout>
    @volt
        <div>
            <x-title title="Create a new Season" />
            @can('create', Season::class)
                <livewire:admin.seasons.create />
            @else
                <div class="text-xl text-red-700">
                    {{ __("You don't have access to this page") }}
                </div>
            @endcan
        </div>
    @endvolt
</x-layout>

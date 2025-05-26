<?php

use App\Models\Season;
use function Laravel\Folio\name;

name('admin.seasons.create');
?>

<x-layout>
    @volt
    <div>
        <x-title title="Create a new Season"/>
        @can('create', Season::class)
            <livewire:admin.season.create/>
        @else
            <div class="text-red-700 text-xl">{{__("You don't have access to this page")}}</div>
        @endcan
    </div>
    @endvolt
</x-layout>

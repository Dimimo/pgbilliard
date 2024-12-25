<?php

use App\Models\Team;
use function Laravel\Folio\name;
use function Livewire\Volt\state;
use function Livewire\Volt\uses;

name('admin.teams.create');
state('team');
?>

<x-layout>
    @volt
    <div>
        <x-title title="Create a new Team"/>
        @can('create', Team::class)
            <livewire:admin.teams.update/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan
    </div>
    @endvolt
</x-layout>

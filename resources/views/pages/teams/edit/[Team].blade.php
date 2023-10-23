<?php

use function Livewire\Volt\
{state, uses
};
use App\Livewire\WithHasAccess;

state(['team' => fn() => $team]);
?>
<x-layout>
    @volt
    <div>
        <x-title title="Edit the team <strong>{{$team->name}}</strong>"/>
        @can('update', $team)
            @can('create', $team)
                <livewire:team.edit :team="$team"/>
            @else
                <livewire:venue :venue="$team->venue"/>
            @endcan

            <livewire:players.edit :team="$team"/>
        @else
            <div class="text-red-700 text-xl">You don't have access to this page</div>
        @endcan

    </div>
    @endvolt
</x-layout>

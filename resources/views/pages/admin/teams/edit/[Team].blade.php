<?php

use function Livewire\Volt\
{state, uses
};
use App\Livewire\WithHasAccess;

state(['team' => fn() => $team])->reactive();
?>
<x-layout>
    @volt
    <div>
        <x-title title="Edit the team <strong>{{$team->name}}</strong>"/>
        <livewire:team.edit :team="$team"/>
        <livewire:players.edit :team="$team"/>
    </div>
    @endvolt
</x-layout>

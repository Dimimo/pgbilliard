<?php

use function Livewire\Volt\
{
    state
};

state(['venue' => fn() => $venue]);

?>
<x-layout>
    @volt
    <div>
        <x-title title="Edit the venue {{ $venue->name }}" />
        <livewire:admin.venue :venue="$venue" />
    </div>
    @endvolt
</x-layout>

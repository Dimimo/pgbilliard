<?php

use function Laravel\Folio\name;

name('teams.index');
?>

<x-layout>
    @volt
        <div>
            <livewire:teams />
        </div>
    @endvolt
</x-layout>

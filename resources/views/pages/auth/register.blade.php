<?php

use function Laravel\Folio\name;

name('register');
?>

<x-layout title="Register">
    @volt
        <div>
            <livewire:auth.register />
        </div>
    @endvolt
</x-layout>

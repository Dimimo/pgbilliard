<?php

use function Laravel\Folio\name;

name('login');
?>

<x-layout title="Login">
    @volt
    <div>
        <livewire:auth.login />
    </div>
    @endvolt
</x-layout>

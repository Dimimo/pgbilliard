<?php

use function Laravel\Folio\name;

name('forgot-password');
?>

<x-layout title="Forgot Password">
    @volt
    <div>
        <livewire:auth.forgot-password />
    </div>
    @endvolt
</x-layout>

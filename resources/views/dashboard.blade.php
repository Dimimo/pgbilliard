<?php

use function Laravel\Folio\{name, middleware};
use function Livewire\Volt\{state, uses};

name('dashboard');
middleware(['auth']);
state([
    'user' => fn() => auth()->user(),
])

?>

<x-layout title="Your Dashboard">
    @volt
    <div>
        <div class="flex justify-center">
            <x-title
                title="Welcome {{ Str::ucfirst($user->name) }}"
                subtitle="Your dashboard for Season {{ session('cycle') }}"
                :gradient="false"
            />
        </div>

        <div class="my-4">
            <livewire:dashboard :user="$user"/>
        </div>
    </div>

    @endvolt
</x-layout>

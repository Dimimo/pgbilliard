<?php

use function Laravel\Folio\name;

name('chat.index');
?>

<x-app-layout>
    @volt
    <section>
        <x-title
            title="Puerto Galera Chat Box"
        />
        @can('create', \App\Models\Chat\ChatRoom::class)
            <livewire:chat.index/>
        @else
            <div class="text-xl">
                You don't have access to this page, to access the Chat,
                simply <a class="text-blue-700 hover:underline" href="{{ route('login') }}" wire:navigate>log in onto your account</a>,
                <a class="text-blue-700 hover:underline" href="{{ route('players.accounts') }}" wire:navigate>claim an existing account</a>
                or <a class="text-blue-700 hover:underline" href="{{ route('register') }}" wire:navigate>create new account</a>.
            </div>
        @endcan
    </section>
    @endvolt
</x-app-layout>

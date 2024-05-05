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
            <div class="text-red-700 text-xl">
                You don't have access to this page, to access the Chat,
                simply <a href="{{ route('login') }}" wire:navigate>log in onto your account</a>.
            </div>
        @endcan
    </section>
    @endvolt
</x-app-layout>

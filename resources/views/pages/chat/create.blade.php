<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('chat.room.create');
state('chatRoom');
?>

<x-layout>
    @volt
        <section>
            <x-title title="Create a chat room" help="chat" />

            @can('create', App\Models\Chat\ChatRoom::class)
                <livewire:chat.create :room="new \App\Models\Chat\ChatRoom()" />
            @else
                <x-chat.no-access />
            @endcan
        </section>
    @endvolt
</x-layout>

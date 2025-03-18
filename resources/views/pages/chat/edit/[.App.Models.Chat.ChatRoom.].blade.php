<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('chat.room.edit');
state('chatRoom');
?>

<x-layout>
    @volt
    <section>
        <x-title
            title="Update your chat room"
            subtitle="{{ $chatRoom->name }}"
        />

        @can('update', $chatRoom)
            <livewire:chat.create :room="$chatRoom"/>
        @else
            <div class="text-xl text-red-700">You don't own this chat room</div>
        @endcan
    </section>
</x-layout>

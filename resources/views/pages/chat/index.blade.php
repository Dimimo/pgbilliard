<?php

use App\Models\Chat\ChatRoom;
use function Laravel\Folio\name;

name('chat.index');
?>

<x-layout>
    @volt
    <section>
        <x-title
            title="General Chat"
            subtitle="For everybody, managed by administrators"
        />
        @can('create', App\Models\Chat\ChatRoom::class)
            <livewire:chat.index/>
        @else
            <x-chat.no-access/>
        @endcan
    </section>
    @endvolt
</x-layout>

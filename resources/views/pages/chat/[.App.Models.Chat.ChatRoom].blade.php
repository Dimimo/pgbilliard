<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('chat.room');
state('chatRoom');
?>

<x-layout>
    @volt
    <section>
        <x-title
            title="{{ $chatRoom->private ? 'Private' : 'Public' }} chat room"
            subtitle="{{ $chatRoom->name }}"
        />

        @can('view', $chatRoom)
            <livewire:chat.room :chatRoom="$chatRoom"/>
        @else
            <x-chat.no-access/>

            @if($chatRoom->private)
                <div class="text-xl my-4">
                    If you try to access a private room, it is possible you are didn't receive an invitation. The room is managed
                    by <strong>{{ $chatRoom->owner->name }}</strong>.
                </div>
            @endif
        @endcan

    </section>

    @endvolt
</x-layout>


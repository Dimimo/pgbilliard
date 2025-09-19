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

            <x-chat.warning />

            @can('view', $chatRoom)
                <livewire:chat.room :chatRoom="$chatRoom" />
            @else
                <x-chat.no-access />

                @if ($chatRoom->private)
                    <div class="my-4 text-xl">
                        If you try to access a private room, it is possible you are didn't receive
                        an invitation.
                    </div>
                @endif
            @endcan
        </section>
    @endvolt
</x-layout>

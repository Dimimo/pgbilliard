<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('chat.room');
state('chatRoom');
?>

<x-app-layout>
    @volt
    <section>
        <x-title
            title="{{ $chatRoom->private ? 'Private' : 'Public' }} chat room"
            subtitle="{{ $chatRoom->name }}"
        />

        @if($chatRoom->private === 0)
            <livewire:chat.room :chatRoom="$chatRoom"/>
        @elseif($chatRoom->users()->find(Auth::id()))
            <livewire:chat.room :chatRoom="$chatRoom"/>
        @else
            <x-chat.no-access/>

            @if($chatRoom->private)
                <div class="text-xl my-4">
                    If you try to access a private room, it is possible you are didn't receive an invitation. The room is managed
                    by <strong>{{ $chatRoom->owner->name }}</strong>.
                </div>
            @endif

        @endif
    </section>

    @endvolt
</x-app-layout>


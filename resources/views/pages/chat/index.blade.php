<?php

use App\Models\Chat\ChatRoom;
use function Laravel\Folio\name;

name('chat.index');
?>

<x-layout>
    @volt
    <section>
        <x-title>
            <x-slot:title>
                General Chat
            </x-slot:title>
            <x-slot:subtitle>
                For everybody, managed by administrators
            </x-slot:subtitle>
        </x-title>

        <x-chat.disabled/>

        {{--<x-chat.warning/>

        @can('create', App\Models\Chat\ChatRoom::class)
            <livewire:chat.index/>
        @else
            <x-chat.no-access/>
        @endcan--}}
    </section>
    @endvolt
</x-layout>

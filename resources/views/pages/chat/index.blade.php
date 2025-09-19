<?php

use App\Models\Chat\ChatRoom;
use function Laravel\Folio\name;

name('chat.index');
?>

<x-layout>
    @volt
        <section>
            <x-title>
                <x-slot:title>General Chat</x-slot>
                <x-slot:subtitle>
                    For everybody, managed by administrators
                </x-slot>
            </x-title>
            <x-chat.disabled />
        </section>
    @endvolt
</x-layout>

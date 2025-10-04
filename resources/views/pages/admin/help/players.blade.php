<?php

use function Laravel\Folio\name;

name('admin.help.schedule');
?>

<x-layout>
    @volt
        <section>
            @if (session('is_admin'))
                <x-title>
                    <x-slot:title>The admin help pages</x-slot>
                    <x-slot:subtitle>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"
                            class="inline-block h-6 w-6 fill-green-600"
                        >
                            <path
                                d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"
                            />
                        </svg>
                        players and users overview
                    </x-slot>
                </x-title>
                <x-admin.help.players-overview />
            @endif
        </section>
    @endvolt
</x-layout>

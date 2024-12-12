<?php

use function Laravel\Folio\name;

name('dashboard');
?>

<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="m-4 border border-indigo-400 bg-indigo-50 p-4 text-lg text-center rounded-lg">
                        <p class="mb-4">
                            This page will become an overview of your state of affairs within the League! Your Dashboard.
                        </p>
                        This website as of today is still in <span class="font-bold">beta test</span>.<br>
                        You can already subscribe and wander around<br>
                        All data is a copy from the 'old' website<br>
                        Some things like the chat doesn't work yet<br>
                        And still, always busy, improving the presentation...<br>
                        ...not my strongest point...<br>
                        I'm a programmer, not a designer
                        <p class="my-4">
                            Cheerio, Dimitri
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

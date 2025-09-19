<?php

use function Laravel\Folio\name;

name('admin.contact');
?>

<x-layout>
    @volt
        <section>
            <x-title title="Send out emails" subtitle="Season {{ session('cycle') }}" />
            @can('create', \App\Models\Schedule::class)
                <div class="m-4 rounded-lg border border-indigo-700 bg-indigo-50 p-4">
                    <div class="mb-4">
                        You may send out a message here to all players and/or captains and even
                        admins. This service is only available for administrators. Only players with
                        an email that are claimed
                        <span class="italic">
                            (i.e. not the
                            @pgbilliard.com
                            default)
                        </span>
                        will receive your message.
                    </div>
                    <div class="mb-4">
                        Why? Mainly for new functionalities that need the attention of Captains. Or
                        a playing week we decided to skip.
                    </div>
                    <div class="font-bold">This service is Season dependable!</div>
                </div>
                <livewire:admin.send-emails />
            @else
                <div class="text-xl text-red-700">
                    {{ __("You don't have access to this page") }}
                </div>
            @endcan
        </section>
    @endvolt
</x-layout>

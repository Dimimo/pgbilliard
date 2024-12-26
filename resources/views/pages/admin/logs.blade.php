<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('admin.logs');
state(['logs' => \Storage::disk('logs')->get("scores.log")]);
?>

<x-layout>
    @volt
    <section>
        @if (auth()->user()?->isAdmin())
            <x-title title="The log file for game score changes"/>
            <div class="my-5 rounded-lg border border-gray-500 bg-gray-50 p-4">
                <p class="mb-4">
                    This is a rather dull print out of the log file where all score changes are kept.
                    It could be of interest in case of a dispute.
                </p>
                <p>
                    It speaks for itself. Who changed what on which game and date and what's the score after that.
                    The confirmation of a finished game is shown as well.<br>
                    All dates are in <span class="italic">Asia/Manila</span> time.
                </p>
            </div>
            <div class="h-auto w-max border-2 border-blue-800 p-2 text-sm">
                {!! nl2br($logs) !!}
            </div>
        @endif
    </section>
    @endvolt
</x-layout>

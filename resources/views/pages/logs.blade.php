<?php

use function Laravel\Folio\name;
use function Livewire\Volt\state;

name('logs');
state(['logs' => \Storage::disk('logs')->get("scores.log")]);
?>

<x-layout>
    @volt
        <section>
            <x-title title="The log file for game score changes" />
            <div class="my-5 rounded-lg border border-gray-500 bg-gray-50 p-4">
                <p class="mb-4">
                    This is a dry print out of the log file where all score changes are kept.
                </p>
                <p class="mb-4">
                    It speaks for itself. Who changed what on which game and date and what's the
                    score after that. The confirmation of a finished game is shown as well.
                    <br />
                </p>
                <p class="mb-4">
                    All dates are in the
                    <span class="italic">Asia/Manila</span>
                    timezone.
                </p>
                <p>The logfile will be archived when a new Season starts.</p>
            </div>
            <div class="h-auto w-max border-2 border-blue-800 p-2 text-sm">
                {!! nl2br($logs) !!}
            </div>
        </section>
    @endvolt
</x-layout>

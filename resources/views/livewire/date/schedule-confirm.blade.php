<div class="grid grid-flow-row grid-cols-8 items-center justify-items-center gap-2">
    @if ($event->score1 + $event->score2 === 15
         ||
         ($event->date->regular && ($event->score1 === 8 || $event->score2 === 8)))
        <div
            class="col-span-8 mt-8 flex w-min flex-col justify-center space-y-3 whitespace-nowrap rounded-lg border-2 border-green-500 text-center"
        >
            <div class="rounded-t-lg border-b-2 border-b-green-500 bg-green-100 p-2 text-2xl">
                {{ __('Final Score') }}:
            </div>

            <x-schedule.final-score-box :event="$event" />

            @if (! $event->confirmed)
                @can('update', $event)
                    <div class="flex justify-center pb-2">
                        <button
                            type="button"
                            title="Confirm the final score"
                            class="block rounded-lg bg-blue-100 p-2 outline outline-blue-600 hover:bg-green-100 hover:outline-green-600"
                            wire:click="consolidate()"
                            wire:confirm="Final score is {{ $event->team_1->name }} {{ $event->score1 }} - {{ $event->score2 }} {{ $event->team_2->name }}\nYou can't change the score after the confirmation."
                        >
                            {{ __('Confirm') }}
                        </button>
                    </div>
                @endcan
            @endif
        </div>
    @else
        <div class="fixed bottom-0 z-50 mt-8">
            <div class="flex justify-center">
                <div
                    class="flex w-min items-center space-x-2 whitespace-nowrap rounded-t-lg border border-blue-800 bg-yellow-100 p-2 text-lg"
                >
                    <x-schedule.final-score-box :event="$event" />
                </div>
            </div>
        </div>
    @endif
</div>

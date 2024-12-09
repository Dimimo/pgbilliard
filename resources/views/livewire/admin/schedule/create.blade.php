<div>
    <article class="my-4 flex flex-col rounded-lg border border-gray-700 bg-green-100 p-4 space-y-2">
        <p>
            Any schedule is based on 4 players per 2 teams and 15 games. Additional players can be added on the day schedule
            agreed by the captains. If only 3 players show up, it's a problem for the captains. Not the schedule itself.
        </p>
        <p>
            <span class="font-bold">Why different schedules?</span> There are now 2 in use for historical reasons. Some captains have their
            preferences. By proposing different schedules, it is up to the captains which Day Schedule they prefer.
        </p>
        <p>
            <span class="font-bold">Some practicalities:</span>
        </p>
        <ul class="ml-4 list-disc">
            <li>Each player should add up to 4 games</li>
            <li>
                If you want to <span class="font-bold">swap some games</span>, reset them to <span class="italic">--select--</span> first
                (there is a complex bug I can't pinpoint, but... read next...)
            </li>
            <li>
                If you do accidentally create a second game on a single game, set one
                to <span class="italic">--select--</span> to make it disappear
            </li>
            <li>The 15th (3rd double) is shown, just leave it empty or reset to empty</li>
            <li>Everything you change is immediately saved in the database</li>
            <li class="font-bold">Sometimes it crashes, just reload to page 🤐</li>
        </ul>
        <p class="font-bold">
            Just make sure the status of each player is <span class="font-bold text-green-700">set to green</span>.
        </p>
        <p>
            Captains can still swap players around if they both agree. These schedules are proposals to simplify the daily schedule makeup.
        </p>
    </article>

    @if (!$format->exists)

        <div class="my-8">
            <form wire:submit="save">
                <label for="name" class="text-lg">Name of the Schedule: </label>
                <input id="name" type="text" wire:model.live="name">
                <x-primary-button>
                    Create
                </x-primary-button>
                @error('name')
                <div class="text-red-700">{{ $message }}</div>
                @enderror
            </form>
        </div>

    @else

        <div class="grid grid-flow-row grid-cols-9 items-center justify-items-center gap-2">
            <div class="col-span-9 h-12 w-full rounded-lg border-2 border-indigo-400 bg-indigo-100 pt-2 text-center text-xl">
                The format used is <span class="font-bold">{{ $format->name }}</span>
            </div>
            <div class="col-span-4 w-full bg-blue-50 p-4 text-right">
                <div class="mb-4 text-lg text-indigo-700">Home Team</div>
                @for($i=1;$i<5;$i++)
                    <div>Home {{ $i }} ({!! trans_choice('plural.games', $format->checkGameNumbers($i, true)) !!})</div>
                @endfor
            </div>
            <div></div>
            <div class="col-span-4 w-full bg-green-50 p-4 text-left">
                <div class="mb-4 text-lg text-green-700">Visitors</div>
                @for($i=1;$i<5;$i++)
                    <div>Visit {{ $i }} ({!! trans_choice('plural.games', $format->checkGameNumbers($i, false)) !!})</div>
                @endfor
            </div>

            @foreach($rounds as $i => $round)
                @php
                    $j = $i+4;
                @endphp
                <div class="col-span-9 h-12 w-full bg-green-100 pt-2 text-center text-xl">{{ $round }} round</div>
                @for($i;$i<$j;$i++)
                    <x-schedule.schedule-table-position :table="$table" :position="$i" :home="true"/>
                @endfor
                <div class="col-span-9 h-12 w-full bg-green-100 pt-2 text-center text-xl">{{ $round }} double</div>
                <x-schedule.schedule-table-position :table="$table" :position="$i" :home="true"/>
            @endforeach
        </div>
    @endif
</div>

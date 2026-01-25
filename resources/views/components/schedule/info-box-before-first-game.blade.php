@props(['event', 'switches', 'format'])

<div
    class="mx-2 mb-4 h-auto rounded-lg border-2 border-indigo-400 bg-indigo-100 p-2 pt-2 text-center text-xl md:mx-0"
>
    {{ __('The format used is the') }}
    <span class="font-bold">{{ $format }}</span>

    @if ($switches->get('canUpdatePlayers') && auth()->check() && auth()->user()->can('update', $event))
        <div class="m-2 text-center text-sm">
            <span class="font-bold">Check the schedule first before starting the game!</span>
            <br />
            After entering the first score, the player order and reserves are locked
            <br />
            You can change any player later on in the schedule itself.
        </div>
        <div class="m-2 text-center text-sm">
            <span class="font-bold">Hint:</span>
            <br />
            If you are not sure if a reserve will show up, add the player anyway.
            <br />
            A reserve with no games doesn't make any difference
            <br />
            for the scoreboard or individual score.
        </div>
    @endif
</div>

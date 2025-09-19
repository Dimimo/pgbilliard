@props(['date'])

<div class="flex flex-col space-y-3 rounded-lg border border-green-500 bg-green-100 p-4">
    <div>
        <span class="font-bold">Use common sense here.</span>
        You can shift (change) dates. There are 2 scenarios when this is needed:
    </div>
    <div>
        1/ A game is played on another day then on {{ $date->date->format('l') }}'s. Let the games
        be played. Shift to the next day so the captains and players can add the score themselves.
    </div>
    <div>
        2/ For some reason, a typhoon for example, the whole future calendar needs to shift one week
        up. In this case, add one week to the finals and work you way up.
    </div>
    <div>
        There is only ONE failsafe. You can't overlap dates. If a date already exists, it won't
        accept your request.
    </div>
    <div>Each request is immediately implemented into the database and calendar.</div>
    <div>
        Shifting the date back to {{ $date->date->format('l') }}'s can be done anytime and
        manually. I could do it programmatically but there is no way to figure out the reason why a
        playing date was changed.
    </div>
</div>

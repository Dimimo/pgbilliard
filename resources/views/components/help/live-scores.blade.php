<div class="text-justify">
    <div class="mb-4">
        On <a href="{{ route('calendar') }}" class="inline-block text-blue-800 link" wire:navigate>
            the Calendar
        </a> you can select any date. There are 3 possibilities presented to you:
    </div>

    <div class="mb-4">
        <ul class="list-inside list-disc">
            <li>a date <span class="font-bold">from the past</span> shows you the end score and a link to the daily schedule individual results</li>
            <li>a date <span class="font-bold">into the future</span> gives you the time remaining for the 'window' to open</li>
            <li>the <span class="font-bold">'time window' is open</span>, games are about to start or have already started</li>
        </ul>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">The calendar day overview set into the future</div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/day_score_future.png') }}" alt="">
        </div>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">The calendar day overview on the day we play from {{ \App\Constants::DATEFORMAT_START }}h to
                {{ \App\Constants::DATEFORMAT_END }}h</div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/day_score_ready.png') }}" alt="">
        </div>
    </div>

    <div class="mb-4">
        If you are playing for a team, you have access to the game you are participating in.
        Every player can update the game scores. In this case, the game
        <span class="font-bold">Pirata Galleon - Victoria</span> can be updated.
        The other games <span class="font-bold">didn't start yet</span>.
    </div>

    <div class="mb-4 rounded-lg border-2 border-green-700 bg-green-100 p-4">
        Every <span class="italic">finished individual game </span>is visible in the Score Board, the Calendar,
        the day overview AND the "Schedules of the day".
        <span class="font-bold">No need to refresh. Score updates are immediately reflected.</span>
    </div>

    <div class="mb-4">
        When the games are actually being played, you notice a link on
        <a href="{{ route('scoreboard') }}" class="inline-block text-blue-800 link" wire:navigate>
            the Scoreboard
        </a>
        and on
        <a href="{{ route('calendar') }}" class="inline-block text-blue-800 link" wire:navigate>
            the Calendar
        </a>
        as <span class="font-bold">Live Scores</span>.
    </div>

    <div class="mb-4">
        <span class="font-bold">From now on you need to be logged in to change a score.</span> Anybody can visit during
        <span class="italic">opening hours</span> from {{ \App\Constants::DATEFORMAT_START }}h to
        {{ \App\Constants::DATEFORMAT_END }}h.
    </div>

    <div class="mb-4">
        <span class="font-bold">There is a logical hierarchy</span>:
        <div class="ml-4">
            <span class="font-bold">Administrators</span>: access to all games <span class="font-semibold">except</span>
            confirmed games, these are immutable<br>
            <span class="font-bold">Bar owners</span>: can change the scores on any team playing for the bar <br>
            <span class="font-bold">Captains and players</span>: can only change the game they are involved in,
            i.e. Victoria has no access to Bluemoon - Tigers<br>
            <span class="font-bold">Visitors or non-players</span>: read only
        </div>
        Notice: if you have access to a game in progress, you have access to both the home and visitor's score.
    </div>

    <div class="mb-4">
        <span class="font-bold">What's with the <span class="text-lg text-blue-800">confirm</span> button?</span>
        <div class="ml-4">
            It appears when the game adds up to 15 games. It's a trigger of sorts. It tells the game is finished and
            the score is final. The Pirata - Geriatric game is set as confirmed.
            The Kickass - Victoria game not yet. <br class="mb-2">
            It comes with a confirmation dialogue. Just to be sure.<br class="mb-2">
            When the final game is confirmed, <span class="font-bold">all participating players get an email with the day results</span>. <br>
            <span class="font-bold">As always</span>:
            <a href="{{ route('scoreboard') }}" class="inline-block text-blue-800 link" wire:navigate>
                the Scoreboard
            </a> and <a href="{{ route('calendar') }}" class="inline-block text-blue-800 link" wire:navigate>
                the Calendar
            </a> are immediately up-to-date.
        </div>
    </div>

    <div class="mb-4 font-bold">
        Confirmed games can't be changed by anybody, not even administrators.
    </div>

    @if(session('is_admin'))
        <div class="mb-4 rounded-lg border-2 border-indigo-700 text-center">
            <div class="mb-4 border-b border-indigo-700 font-bold">
                <div class="rounded-t-lg bg-indigo-100 p-4">Only for administrators</div>
            </div>
            <div class="mb-4">
                As an administrator you can still change the score directly as it was before. <br>
                The reason? In case of a <span class="font-bold">no-show (8-0)</span>. No daily individual scores
                will be available as there aren't any.
            </div>
            <div class="w-full rounded-lg border border-gray-500 bg-white p-2 text-center">
                <div class="my-2 font-bold">What an administrator sees when a game is <span class="font-bold">not confirmed</span></div>
                <img src="{{ secure_url('/images/schedule/admin_direct_score_overview.png') }}" alt="">
            </div>
        </div>
    @endif
</div>

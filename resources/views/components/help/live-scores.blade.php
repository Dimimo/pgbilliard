<div class="text-justify">
    <div class="mb-4">
        When the games are actually being played, you notice a link on
        <a href="{{ route('scoresheet') }}" class="inline-block text-blue-800 link" wire:navigate>
            the Scoresheet
        </a>
        and on
        <a href="{{ route('calendar') }}" class="inline-block text-blue-800 link" wire:navigate>
            the Calendar
        </a>
        as <span class="font-bold">Live Scores</span>. It looks like this <br>
        <span class="text-sm">(from the test server, not real data 🤫)</span>
    </div>
    <div class="mb-4">
        <img src="{{ secure_url('/images/day-event-score-input.png') }}" class="w-min rounded-lg border border-gray-500 text-center p-2" alt="">
    </div>
    <div class="mb-4">
        <span class="font-bold">From now on you need to be logged in to change a score.</span> Anybody can visit during
        <span class="italic">opening hours</span> from {{ \App\Constants::DATEFORMAT_START }}h to
        {{ \App\Constants::DATEFORMAT_END }}h.
    </div>
    <div class="mb-4">
        <span class="font-bold">What do we see?</span>
        <div class="ml-4">
            <span class="font-bold">Pirata 7-8 Geriatric</span>: a finished game that has been confirmed <br>
            <span class="font-bold">Kickass 7-8 Victoria</span>: a finished game ready to be confirmed <br>
            <span class="font-bold">Bluemoon 1-1 Tigers</span>: a game in progress
        </div>

    </div>
    <div class="mb-4">
        The picture shows what administrators see. <span class="font-bold">There is a logical hierarchy</span>:
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
        <span class="font-bold">What's with the <span class="text-blue-800 text-lg">confirm</span> button?</span>
        <div class="ml-4">
            It appears when the game adds up to 15 games. It's a trigger of sorts. It tells the game is finished and
            the score is final. The Pirata - Geriatric game is set as confirmed.
            The Kickass - Victoria game not yet. <br class="mb-2">
            It comes with a confirmation dialogue. Just to be sure.<br class="mb-2">
            When the final game is confirmed, <span class="font-bold">all participating players get an email with the day results</span>. <br>
            <span class="font-bold">As always</span>:
            <a href="{{ route('scoresheet') }}" class="inline-block text-blue-800 link" wire:navigate>
                the Scoresheet
            </a> and <a href="{{ route('calendar') }}" class="inline-block text-blue-800 link" wire:navigate>
                the Calendar
            </a> are immediately up-to-date.
        </div>
    </div>
    <div class="mb-4">
        <span class="font-bold">Changing scores</span>: either by the
        <img src="{{ secure_asset('svg/minus-box-fill.svg') }}" class="inline-block" width="16" height="16" alt="">
        or the <img src="{{ secure_asset('svg/plus-box-fill.svg') }}" class="inline-block" width="16" height="16" alt="">
        buttons. Or change it directly in the box as it was before. Either way works. There are some simple checks, f.ex.
        there can't be more than 15 games. A warning is given because such score can't be confirmed.
    </div>
    <div class="mb-4 font-bold">
        Confirmed games can't be changed by anybody, not even administrators.
    </div>
</div>

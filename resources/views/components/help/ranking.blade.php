<div class="text-justify">
    <div class="mb-4 font-bold">
        <span class="underline">Disclaimer</span>
        : this feature is still experimental and open to changes.
    </div>
    <div class="mb-4">
        Since the detailed scoreboard is now recorded in the database, it is possible to outline an
        individual scoresheet. What you see here is premature as it has limited data to play with.
        With more games finished, the list will become a better reflection of individual efforts.
    </div>
    <div class="mb-4">
        You may have noticed it only shows the
        <span class="font-bold">top 10</span>
        . There are of course more active players in the current Season. For the moment, we limit
        the list to 10. You can see your personal ranking on the Dashboard.
    </div>
    <div class="mb-4">
        <span class="font-bold">A double game</span>
        results in a win (or loss) of 2 players. The ranking doesn't differentiate between singles
        or doubles.
    </div>
    <div class="mb-4">
        <span class="font-bold">Changing teams</span>
        has no influence on individual achievements. The only thing that changes is the current team
        name.
    </div>
    <div class="mb-4 font-bold">Some explanation:</div>
    <div class="mb-4 flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.percent-solid color="fill-indigo-500" size="5" />
        </div>
        <div class="flex-1">
            <div>
                The percentage is calculated as following
                <br />
                (gW = games won, gL = games lost, P = dates participated in, T = total played dates)
            </div>
            <div class="m-4 font-mono">(gW / (gW + gL)) * (P / T) * 100</div>
            <div>
                As you see, it's not perfect. A work in progress. If a player has 1 game every week
                and wins, it results in 100%. We'll have to find a way to avoid such scenario and
                yet keep it honest for every player involved. A logarithmic multiplier maybe.
            </div>
        </div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.thumbs-up-solid color="fill-green-600" size="5" />
        </div>
        <div class="flex-1">Individual games won</div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.thumbs-down-solid color="fill-red-600" size="5" />
        </div>
        <div class="flex-1">Individual games lost</div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.hashtag-solid color="fill-blue-700" size="5" />
        </div>
        <div class="flex-1">
            Total played games, of course, simply the sum of lost and won games,
            <span class="font-bold">unless</span>
            a game is in progress and the players hasn't played the scheduled games yet.
        </div>
    </div>
    <div class="flex">
        <div class="h-12 w-12 flex-none">
            <x-svg.calendar-days-solid color="fill-green-700" size="5" />
        </div>
        <div class="flex-1">
            <div class="mb-2">
                The daily game the players
                <span class="underline">has participated in</span>
                . If for some reason, a player couldn't show up, it will be reflected here. For now,
                it has a negative influence on your percentage.
            </div>
            <div>
                This may change in the future and be compared to the total games the player has
                participated in. And lesser the influence the amount of days the player has actually
                played in.
            </div>
        </div>
    </div>
</div>

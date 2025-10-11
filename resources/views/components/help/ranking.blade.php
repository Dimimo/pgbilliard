<div class="text-justify">
    <div class="mb-4 font-bold">
        <span class="underline">Disclaimer</span>
        : this feature is finally out of beta phase and considered complete.
    </div>
    <div class="mb-4">
        Since the detailed scoreboard is now recorded in the database, it is possible to outline an
        individual scoresheet.
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
            </div>
            <div class="m-4">
                <math xmlns="http://www.w3.org/1998/Math/MathML">
                    <mrow>
                        <mo>(</mo>
                        <mfrac>
                            <mtext>{{__('Games Won')}}</mtext>
                            <mtext>{{__('Total Games')}}</mtext>
                        </mfrac>
                        <mo>)</mo>
                        <mo>
                            <x-svg.xmark-solid color="fill-black" size="4" padding="mt-1" />
                        </mo>
                        <mo>(</mo>
                        <mfrac>
                            <mtext>{{__('Days Participated')}}</mtext>
                            <mtext>{{__('Max Playing Days')}}</mtext>
                        </mfrac>
                        <mo>)</mo>
                        <mo>
                            <x-svg.xmark-solid color="fill-black" size="4" padding="mt-1" />
                        </mo>
                        <mn>100</mn>
                    </mrow>
                </math>
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
                <span class="underline">has participated in.</span>
            </div>
        </div>
    </div>
</div>

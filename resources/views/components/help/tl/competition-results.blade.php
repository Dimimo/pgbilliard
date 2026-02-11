<div class="text-justify">
    <div class="mb-4">
        The main page and the first page you see when you go to the website or log in. It speaks for
        itself if you know what you are looking at. Anybody can see this page by the way, if you are
        logged in or not.
    </div>
    <div class="mb-4">
        Each team appears twice. First in the ranking, then in your latest game. Home and away
        status is irrelevant! Check
        <a
            class="text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('calendar') }}"
            wire:navigate
        >
            the Calendar
        </a>
        to see the details of your day-to-day games.
    </div>
    <div class="mb-4">
        The ranking is determined by (1) alphabetical order, (2) your daily wins, (3) the amount of
        individual games won vs (4) the lost individual games. Lost daily games are irrelevant in
        the makeup of the ranking.
    </div>
    <div class="mb-4">
        Teams that didn't make it to the finals are negatively influenced by the percentage AND
        number of games. This is to avoid that the nr 3 can have a higher percentage than the
        runner-up.
    </div>
    <div class="mb-4">
        Team and individual wins influence the score. To get a 100% you should win every game at the
        maximum score of 15/0.
    </div>
    <div class="mb-4">
        <x-svg.percent-solid color="fill-indigo-500" size="5" />
        is calculated as following (where TG = total games, including semi and finals)
        <div class="m-4 text-center font-mono">
            <math xmlns="http://www.w3.org/1998/Math/MathML">
                <mrow>
                    <mfrac>
                        <mrow>
                            <mfrac>
                                <mtext>{{ __('Games Won') }}</mtext>
                                <mtext>{{ __('Total Games') }}</mtext>
                            </mfrac>
                            <mo>&times;</mo>
                            <mn>100</mn>
                            <mo>+</mo>
                            <mfrac>
                                <mtext>{{ __('Individual Games Won') }}</mtext>
                                <mrow>
                                    <mtext>{{ __('Total Games') }}</mtext>
                                    <mo>&times;</mo>
                                    <mn>15</mn>
                                </mrow>
                            </mfrac>
                            <mo>&times;</mo>
                            <mn>100</mn>
                        </mrow>
                        <mn>2</mn>
                    </mfrac>
                    <mo>&times;</mo>
                    <mtext>factor</mtext>
                </mrow>
            </math>
        </div>
    </div>
    <div class="mb-4">
        The
        <span class="font-bold">factor</span>
        has only an influence to finalists. The winner gets a factor of 1.3 or 30% extra on the
        percentage. The runner-up gets 15% extra. All other teams get a factor of 1. Reason? In
        previous Seasons, it was possible the nr 3 ended up with a better percentage than the runner
        up...
    </div>
    <div class="mb-4">
        BYE games are excluded in any calculation as they are not considered a game.
    </div>
    <div class="mb-4">
        If 2 teams end up with the same scores (daily + individual), the ranking will be alphabetic.
        The calculation does not take mutual game results into account. If this is the case, please
        refer to our
        <a
            class="font-bold text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('forum.posts.index') }}"
            wire:navigate
        >
            our Forum
        </a>
        where we can talk about anything (replaces FaceBook).
    </div>
    <div class="mb-4">
        Last but not least, the symbols.
        <span class="font-bold">Some columns may be hidden on your device.</span>
        It depends on the width of your screen. It's a table and tables have their awkward
        limitations.
    </div>
    <div class="mb-4">
        <span class="font-bold">The site is build on mobile first.</span>
        In the table, some columns are
        <span class="font-bold">dropped</span>
        (
        <x-svg.minus-solid color="fill-red-700" size="5" padding="-mr-1" />
        ) on smaller devices but
        <span class="font-bold">visible</span>
        on larger screens (
        <x-svg.plus-solid color="fill-green-700" size="5" padding="-mr-1" />
        ).
        <span class="text-sm">
            The width of the screens are: extra small (xs) < 640px, small (sm) > 640px, medium (md)
            > 768px, large (lg) >1024px.
        </span>
    </div>
    <table class="table-auto border-separate">
        <thead>
            <tr>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">
                    <x-svg.circle-question-regular color="fill-gray-600" size="5" />
                </th>
                <th class="h-12 w-auto border border-indigo-400 bg-indigo-50 px-2 text-left">
                    Explanation
                </th>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">xs</th>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">sm</th>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">md</th>
                <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">lg</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.circle-info-solid color="fill-green-600" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    Ranking, last game and score (check
                    <a
                        class="text-blue-800 hover:text-blue-600 hover:underline"
                        href="{{ route('calendar') }}"
                        wire:navigate
                    >
                        the Calendar
                    </a>
                    for details)
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.list-ul-solid color="fill-gray-400" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    {{ __('Individual Games and Results') }}
                    <x-svg.eye-regular color="fill-sky-600" size="5" padding="ml-2 mb-1" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.thumbs-up-solid color="fill-green-600" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    The number of daily games won (8 or higher is a win)
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.thumbs-down-solid color="fill-red-600" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    The number of daily games lost (7 or lower)
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.square-plus-solid color="fill-green-600" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    The number of individual games won, including doubles
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.square-minus-solid color="fill-orange-500" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    The number of individual games lost
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.percent-solid color="fill-indigo-500" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    Percentage based on team effort and individual outcome
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
            <tr>
                <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                    <x-svg.champagne-glasses-solid color="fill-blue-800" size="5" />
                </td>
                <td class="h-12 w-auto border border-gray-300 p-2">
                    The number of games played
                    <span class="italic">(including no-show)</span>
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.minus-solid color="fill-red-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
                <td class="h-12 w-12 border border-gray-300 text-center">
                    <x-svg.plus-solid color="fill-green-700" />
                </td>
            </tr>
        </tbody>
    </table>
</div>

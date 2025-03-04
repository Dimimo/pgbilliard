<div class="text-justify">
    <p class="mb-4">
        The main page and the first page you see when you go to the website or log in. It speaks for itself if you know
        what you are looking at. Anybody can see this page by the way, if you are logged in or not.
    </p>
    <p class="mb-4">
        Each team appears twice. First in the ranking, then in your latest game. Home and away status is irrelevant!
        Check <a
            class="text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('calendar') }}"
            wire:navigate
        >
            the Calendar
        </a> to see the details of your day-to-day games.
    </p>
    <p class="mb-4">
        The ranking is determined by (1) alphabetical order, (2) your daily wins, (3) the amount of individual games won
        vs (4) the lost individual games. Lost daily games are irrelevant in the makeup of the ranking.
    </p>
    <p class="mb-4">
        Teams that didn't make it to the finals are negatively influenced by the percentage AND number of games.
        This is to avoid that the nr 3 can have a higher percentage than the runner-up.
    </p>
    <p class="mb-4">
        Team and individual wins influence the score. To get a 100% you should win every game at the maximum score of 15/0.
    </p>
    <p class="mb-4">
        <x-svg.percent-solid color="fill-indigo-500" size="5"/> is calculated as following (where TG = total games,
        including semi and finals)<br>
        <span class="font-mono">(((Games Won / TG) x 100) + (Individual Games Won / (TG x 15) x 100) / 2 * factor)</span>
    </p>
    <p class="mb-4">
        The <span class="font-bold">factor</span> has only an influence to finalists. The winner gets a factor of 1.3 or 30% extra on
        the percentage. The runner-up gets 15% extra. All other teams get a factor of 1.
    </p>
    <p class="mb-4">
        BYE games are excluded in any calculation as they are not considered a game.
    </p>
    <p class="mb-4">
        If 2 teams end up with the same scores (daily + individual), the ranking will be alphabetic. The calculation
        does not take mutual game results into account. If this is the case, please refer
        to our <a
            class="font-bold text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('forum.posts.index') }}"
            wire:navigate
        >
            our Forum
        </a> where we can talk about anything (replaces FaceBook).
    </p>
    <p class="mb-4">
        Last but not least, the symbols. <span class="font-bold">Some columns may be hidden on your device.</span>
        It depends on the width of your screen. It's a table and tables have their awkward limitations.
    </p>
    <p class="mb-4">
        <span class="font-bold">The site is build on mobile first.</span> In the table, some columns are
        <span class="font-bold">dropped</span> (<x-svg.minus-solid color="fill-red-700" size="5" padding="-mr-1"/>)
        on smaller devices but <span class="font-bold">visible</span> on larger screens
        (<x-svg.plus-solid color="fill-green-700" size="5" padding="-mr-1"/>).
        <span class="text-sm">The width of the screens are:
        extra small (xs) < 640px, small (sm) > 640px, medium (md) > 768px, large (lg) >1024px.</span>
    </p>
    <table class="table-auto border-separate">
        <thead>
        <tr>
            <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">
                <x-svg.circle-question-regular color="fill-gray-600" size="5"/>
            </th>
            <th class="h-12 w-auto border border-indigo-400 bg-indigo-50 px-2 text-left">Explanation</th>
            <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">xs</th>
            <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">sm</th>
            <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">md</th>
            <th class="h-12 w-12 border border-indigo-400 bg-indigo-50 px-2 text-center">lg</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                <x-svg.circle-info-solid color="fill-green-600" size="5"/>
            </td>
            <td class="h-12 w-auto border border-gray-300 p-2">
                Ranking, last game and score (check <a
                    class="text-blue-800 hover:text-blue-600 hover:underline"
                    href="{{ route('calendar') }}"
                    wire:navigate
                >
                    the Calendar
                </a> for details)
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
        </tr>
        <tr>
            <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                <x-svg.thumbs-up-solid color="fill-green-600" size="5"/>
            </td>
            <td class="h-12 w-auto border border-gray-300 p-2">
                The number of daily games won (8 or higher is a win)
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
        </tr>
        <tr>
            <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                <x-svg.thumbs-down-solid color="fill-red-600" size="5"/>
            </td>
            <td class="h-12 w-auto border border-gray-300 p-2">
                The number of daily games lost (7 or lower)
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
        </tr>
        <tr>
            <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                <x-svg.square-plus-solid color="fill-green-600" size="5"/>
            </td>
            <td class="h-12 w-auto border border-gray-300 p-2">
                The number of individual games won, including doubles
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
        </tr>
        <tr>
            <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                <x-svg.square-minus-solid color="fill-orange-500" size="5"/>
            </td>
            <td class="h-12 w-auto border border-gray-300 p-2">
                The number of individual games lost
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
        </tr>
        <tr>
            <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                <x-svg.percent-solid color="fill-indigo-500" size="5"/>
            </td>
            <td class="h-12 w-auto border border-gray-300 p-2">
                Percentage based on team effort and individual outcome
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
        </tr>
        <tr>
            <td class="h-12 w-12 border border-gray-300 p-2 text-center">
                <x-svg.champagne-glasses-solid color="fill-blue-800" size="5"/>
            </td>
            <td class="h-12 w-auto border border-gray-300 p-2">
                The number of games played <span class="italic">(including no-show)</span>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.minus-solid color="fill-red-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
            <td class="h-12 w-12 border border-gray-300 text-center">
                <x-svg.plus-solid color="fill-green-700"/>
            </td>
        </tr>
        </tbody>
    </table>
</div>

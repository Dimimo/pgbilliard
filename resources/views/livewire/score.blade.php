<div class="overflow-x-auto">
    <x-title title="Competition Results" help="scoreboard">
        <x-slot:subtitle>
            <div>Season {{ $cycle }}</div>
            @if($date->checkOpenWindowAccess())
                <div class="mt-4 flex justify-center text-lg text-indigo-700">
                    <a
                        href="{{ route('dates.show', ['date' => $date]) }}"
                        class="animate-pulse link"
                        wire:navigate
                    >
                        Live update!
                    </a>
                </div>
            @endif
        </x-slot:subtitle>
    </x-title>

    <x-navigation.main-links-buttons/>

    <div
        class="lg:hidden my-2 mx-auto w-min md:ml-auto md:mr-6 whitespace-nowrap rounded-full border border-gray-500 bg-gray-100 text-center">
        <button class="px-4 py-2" wire:click="toggleShowFullTable">
            {{ $show_full_table ? 'Hide some' : 'Show all' }} columns
        </button>
    </div>

    <table class="my-2 min-w-full bg-transparent table-collapse md:my-4">
        <thead class="whitespace-nowrap">
        <tr>
            <th class="bg-gray-300 p-2 text-center text-gray-900">#</th>
            <th class="bg-blue-300 p-2 text-left text-gray-900">Team</th>
            <th class="bg-amber-300 p-2 text-left text-gray-900">Last game</th>
            <th class="bg-yellow-200 p-2 text-center text-gray-900" title="Last scores">Score</th>
            <th @class([
                'bg-green-300 p-2 text-gray-900',
                'hidden sm:table-cell' => ! $show_full_table
            ])>
                <x-svg.thumbs-up-solid color="fill-green-600" size="5"/>
            </th>
            <th @class([
                'bg-red-200 p-2 text-gray-900',
                'hidden sm:table-cell' => ! $show_full_table
            ])>
                <x-svg.thumbs-down-solid color="fill-red-600" size="5"/>
            </th>
            <th @class([
                'bg-green-300 p-2 text-gray-900',
                'hidden lg:table-cell' => ! $show_full_table
            ])>
                <x-svg.square-plus-solid color="fill-green-600" size="5"/>
            </th>
            <th @class([
                'bg-red-200 p-2 text-gray-900',
                'hidden lg:table-cell' => ! $show_full_table
            ])>
                <x-svg.square-minus-solid color="fill-orange-500" size="5"/>
            </th>
            <th @class([
                'bg-purple-300 p-2 text-gray-900',
                'hidden md:table-cell' => ! $show_full_table
            ]) title="Percentage">
                <x-svg.percent-solid color="fill-indigo-500" size="5"/>
            </th>
            <th @class([
                'bg-indigo-300 p-2 text-gray-900',
                'hidden md:table-cell' => ! $show_full_table
            ]) title="Number of games participated">
                <x-svg.champagne-glasses-solid color="fill-blue-800" size="5"/>
            </th>
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach ($scores as $score)
            @if (!$score->get('played'))
                <div class="m-5 box-rounded-danger">
                    <h3 class="center">No games yet</h3>
                </div>
                @break
            @else
                @php
                    if (is_countable($score->get('last_result'))) {
                        $score1 = $score->get('last_result')->get('score1');
                        $score2 = $score->get('last_result')->get('score2');
                    }
                @endphp

                <tr class="h-8" wire:key="{{ $score->get('id') }}">
                    <td class="bg-gray-200 p-2 text-center text-gray-900" title="Your current position">
                        <strong>{{ $i++ }}</strong>
                    </td>
                    <td
                        @class([
                            'p-2',
                            'bg-green-300' => $my_team === $score->get('team')->id,
                            'bg-blue-100' => $my_team !== $score->get('team')->id
                        ])
                        id="team_{{ $score->get('team')->id }}"
                        wire:click.self="setMyTeam({{ $score->get('team')->id }})"
                    >
                        <a href="{{ route('teams.show', ['team' => $score->get('team')]) }}" class="link" wire:navigate>
                            {{ $score->get('team')->name }}
                        </a>
                    </td>
                    <td class="bg-amber-200 p-2 text-gray-900" title="Last played Team (week {{ $week }})">
                        <a href="{{ route('teams.show', ['team' => $score->get('played')]) }}" class="link" wire:navigate>
                            @if ($score->get('max_games') === $score->get('games_played'))
                                {{ $score->get('played')->name }}
                            @else
                                {!! $score->get('played')->name.' <span class="text-gray-600"><i>('.$score->get('games_played').')</i></span>' !!}
                            @endif
                        </a>
                    </td>
                    <td @class([
                            'text-center',
                            'p-2',
                            'bg-amber-100' => !is_null($score_id) && $score_id != $score->get('id'),
                            'text-lg text-blue-700 bg-blue-100' => !is_null($score_id) && $score_id == $score->get('id')
                        ])
                    >
                        @if ($score->get('last_result') === 'not in')
                            <span class="text-orange-600"><i>not in</i></span>
                        @elseif ($score->get('last_result') === 'BYE')
                            <span class="text-gray-600">BYE</span>
                        @else
                            <div class="flex items-center justify-center space-x-2">
                                <div @class([
                                        'text-green-700 text-lg font-semibold' => $score1 > 7,
                                    ])>
                                    {{ $score1 }}
                                </div>
                                <div>
                                    <x-svg.minus-solid color="fill-gray-600" size="3" padding=""/>
                                </div>
                                <div @class([
                                        'text-green-700 text-lg font-semibold' => $score2 > 7,
                                    ])>
                                    {{ $score2 }}
                                </div>
                            </div>
                        @endif
                    </td>
                    <td @class([
                        'bg-green-200 p-2 text-center text-gray-900',
                        'hidden sm:table-cell' => ! $show_full_table
                    ]) title="Daily games won">
                        {{ $score->get('won') }}
                    </td>
                    <td @class([
                        'bg-red-100 p-2 text-center text-gray-900',
                        'hidden sm:table-cell' => ! $show_full_table
                    ]) title="Daily games lost">
                        {{ $score->get('lost') }}
                    </td>
                    <td @class([
                        'bg-green-200 p-2 text-center text-gray-900',
                        'hidden lg:table-cell' => ! $show_full_table
                    ]) title="Total games won">
                        {{ $score->get('for') }}
                    </td>
                    <td @class([
                        'bg-red-100 p-2 text-center text-gray-900',
                        'hidden lg:table-cell' => ! $show_full_table
                    ]) title="Total games lost">
                        {{ $score->get('against') }}
                    </td>
                    <td @class([
                        'bg-purple-100 p-2 text-center text-gray-900',
                        'hidden md:table-cell' => ! $show_full_table
                    ]) title="Percentage">
                        {{ $score->get('percentage') }}%
                    </td>
                    <td @class([
                        'bg-indigo-100 p-2 text-center text-gray-900',
                        'hidden md:table-cell' => ! $show_full_table
                    ])
                        title="{{ $score->get('games_played') }} games participated">
                        {{ $score->get('games_played') }}
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

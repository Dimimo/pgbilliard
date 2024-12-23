<div class="overflow-x-auto">
    <x-title title="Competition Results" subtitle="">
        <x-slot:subtitle>
            <div>Season {{ $cycle }}</div>
            @if(($hasAccess || $date->checkOpenWindowAccess()))
                <div class="text-lg text-indigo-700">
                    <a
                        href="{{ route('dates.show', ['date' => $date]) }}"
                        class="hover:underline"
                        wire:navigate
                    >
                        Live update!
                    </a>
                </div>
            @endif
        </x-slot:subtitle>
    </x-title>
    <table class="mb-4 min-w-full bg-transparent table-collapse">
        <thead class="whitespace-nowrap">
        <tr>
            <th class="bg-gray-300 p-2 text-center text-gray-900">#</th>
            <th class="bg-blue-300 p-2 text-left text-gray-900">Team</th>
            <th class="bg-amber-300 p-2 text-left text-gray-900">Last game</th>
            <th class="bg-yellow-200 p-2 text-center text-gray-900" title="Last scores">Score</th>
            <th class="hidden bg-green-300 p-2 text-gray-900 sm:table-cell">
                <x-svg.thumbs-up-solid color="fill-green-600" size="5"/>
            </th>
            <th class="hidden bg-red-200 p-2 text-gray-900 sm:table-cell">
                <x-svg.thumbs-down-solid color="fill-red-600" size="5"/>
            </th>
            <th class="hidden bg-green-300 p-2 text-gray-900 md:table-cell">
                <x-svg.square-plus-solid color="fill-green-600" size="5"/>
            </th>
            <th class="hidden bg-red-200 p-2 text-gray-900 md:table-cell">
                <x-svg.square-minus-solid color="fill-orange-500" size="5"/>
            </th>
            <th class="hidden bg-purple-300 p-2 text-gray-900 lg:table-cell" title="Percentage">
                <x-svg.percent-solid color="fill-indigo-500" size="5"/>
            </th>
            <th class="hidden bg-indigo-300 p-2 text-gray-900 lg:table-cell" title="Number of games participated">
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

                <tr wire:key="{{ $score->get('id') }}">
                    <td class="bg-gray-200 p-2 text-center text-gray-900" title="Your current position">
                        <strong>{{ $i++ }}</strong>
                    </td>
                    <td
                        @class([
                            'p-2',
                            'bg-green-300' => $my_team === $score->get('team')->id,
                            'bg-blue-100' => $my_team !== $score->get('team')->id
                        ])µ
                        id="team_{{ $score->get('team')->id }}"
                        wire:click.self="setMyTeam({{ $score->get('team')->id }})"
                    >
                        <a href="{{ route('teams.show', ['team' => $score->get('team')]) }}" class="text-gray-900" wire:navigate>
                            {{ $score->get('team')->name }}
                        </a>
                    </td>
                    <td class="bg-amber-200 p-2 text-gray-900" title="Last played Team (week {{ $week }})">
                        <a href="{{ route('teams.show', ['team' => $score->get('played')]) }}" class="text-gray-900" wire:navigate>
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
                            <span class="text-gray-900">{{ $score->get('last_result') }}</span>
                        @endif
                    </td>
                    <td class="hidden bg-green-200 p-2 text-center text-gray-900 sm:table-cell" title="Daily games won">
                        {{ $score->get('won') }}
                    </td>
                    <td class="hidden bg-red-100 p-2 text-center text-gray-900 sm:table-cell" title="Daily games lost">
                        {{ $score->get('lost') }}
                    </td>
                    <td class="hidden bg-green-200 p-2 text-center text-gray-900 md:table-cell" title="Total games won">
                        {{ $score->get('for') }}
                    </td>
                    <td class="hidden bg-red-100 p-2 text-center text-gray-900 md:table-cell" title="Total games lost">
                        {{ $score->get('against') }}
                    </td>
                    <td class="hidden bg-purple-100 p-2 text-center text-gray-900 lg:table-cell" title="Percentage">
                        {{ $score->get('percentage') }}%
                    </td>
                    <td class="hidden bg-indigo-100 p-2 text-center text-gray-900 lg:table-cell"
                        title="{{ $score->get('games_played') }} games participated">
                        {{ $score->get('games_played') }}
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

<div class="overflow-x-auto">
    <x-title title="Competition Results" subtitle="Season {{ $cycle }}" />
    <table class="min-w-full mb-4 table-collapse bg-transparent">
        <thead class="whitespace-nowrap">
        <tr>
            <th class="p-2 text-center bg-gray-300 text-gray-900">#</th>
            <th class="p-2 text-left bg-blue-300 text-gray-900">Team</th>
            <th class="p-2 text-left bg-amber-300 text-gray-900">Last game</th>
            <th class="p-2 text-center bg-yellow-200 text-gray-900" title="Last scores">Score</th>
            <th class="p-2 bg-green-300 text-gray-900">
                <img class="mx-auto" src="{{ secure_asset('svg/thumbs-up-fill.svg') }}" alt="Games won" width="24" height="24">
            </th>
            <th class="p-2 bg-red-200 text-gray-900">
                <img class="mx-auto" src="{{ secure_asset('svg/thumbs-down-fill.svg') }}" alt="Games lost" width="24" height="24">
            </th>
            <th class="p-2 bg-green-300 text-gray-900 hidden sm:table-cell">
                <img class="mx-auto" src="{{ secure_asset('svg/plus-box-fill.svg') }}" alt="Wins" width="24" height="24">
            </th>
            <th class="p-2 bg-red-200 text-gray-900 hidden sm:table-cell">
                <img class="mx-auto" src="{{ secure_asset('svg/minus-box-fill.svg') }}" alt="Against" width="24" height="24">
            </th>
            <th class="p-2 bg-purple-300 text-gray-900">
                <img class="mx-auto" src="{{ secure_asset('svg/percentage.svg') }}" alt="Percentage">
            </th>
            <th class="p-2 bg-indigo-300 text-gray-900">
                <img class="mx-auto" src="{{ secure_asset('svg/wine-glasses.svg') }}" alt="Number of games participated">
            </th>
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach ($scores as $score)
            @if (!$score->get('played'))
                <div class="box-rounded-danger m-5">
                    <h3 class="center">No games yet</h3>
                </div>
                @break
            @else

                <tr wire:key="{{ $score->get('id') }}">
                    <td class="p-2 text-center bg-gray-200 text-gray-900" title="Your current position">
                        <strong>{{ $i++ }}</strong>
                    </td>
                    <td
                        class="p-2 @if($my_team === $score->get('team')->id) bg-green-300 @else bg-blue-100 @endif"
                        id="team_{{ $score->get('team')->id }}"
                        wire:click.self="setMyTeam({{ $score->get('team')->id }})"
                    >
                        <a href="/teams/show/{{ $score->get('team')->id }}" class="text-gray-900" wire:navigate>
                            {{ $score->get('team')->name }}
                        </a>
                    </td>
                    <td class="p-2 bg-amber-200 text-gray-900" title="Last played Team (week {{ $week }})">
                        <a href="/teams/show/{{ $score->get('played')->id }}" class="text-gray-900" wire:navigate>
                            @if ($score->get('max_games') === $score->get('games_played'))
                                {{ $score->get('played')->name }}
                            @else
                                {!! $score->get('played')->name.' <span class="text-gray-600"><i>('.$score->get('games_played').')</i></span>' !!}
                            @endif
                        </a>
                    </td>
                    <td class="text-center p-2 bg-amber-100 @if(!is_null($score_id) && $score_id == $score->get('id')) text-lg text-blue-700 bg-blue-100 @endif">
                        @if ($score->get('last_result') === 'not in')
                            <span class="text-orange-600"><i>not in</i></span>
                        @elseif ($score->get('last_result') === 'BYE')
                            <span class="text-gray-600">BYE</span>
                        @else
                            <span class="text-gray-900">{{ $score->get('last_result') }}</span>
                        @endif
                    </td>
                    <td class="text-center p-2 bg-green-200 text-gray-900" title="Daily games won">
                        {{ $score->get('won') }}
                    </td>
                    <td class="text-center p-2 bg-red-100 text-gray-900" title="Daily games lost">
                        {{ $score->get('lost') }}
                    </td>
                    <td class="text-center p-2 bg-green-200 text-gray-900 hidden sm:table-cell" title="Total games won">
                        {{ $score->get('for') }}
                    </td>
                    <td class="text-center p-2 bg-red-100 text-gray-900 hidden sm:table-cell" title="Total games lost">
                        {{ $score->get('against') }}
                    </td>
                    <td class="text-center p-2 bg-purple-100 text-gray-900" title="Percentage">
                        {{ $score->get('percentage') }}%
                    </td>
                    <td class="text-center p-2 bg-indigo-100 text-gray-900" title="{{ $score->get('games_played') }} games participated">
                        {{ $score->get('games_played') }}
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>

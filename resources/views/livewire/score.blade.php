<div>
    <div class="overflow-x-auto">
        <x-title title="Competition Results" help="scoreboard">
            <x-slot:subtitle>
                <div>{{ __('Season') }} {{ Context::getHidden('cycle') }}</div>
                @if ($date && $date->checkOpenWindowAccess())
                    <x-svg.live-button-bouncing :date="$date" />
                @endif
            </x-slot>
        </x-title>

        <x-navigation.main-links-buttons />

        <div
            class="mx-auto my-2 w-min whitespace-nowrap rounded-full border border-gray-500 bg-gray-100 text-center md:ml-auto md:mr-6 lg:hidden"
        >
            <button class="px-4 py-2" wire:click="toggleShowFullTable">
                {{ $show_full_table ? 'Hide some' : 'Show all' }} {{ __('columns') }}
            </button>
        </div>

        <table class="table-collapse my-2 min-w-full bg-transparent md:my-4">
            <thead class="whitespace-nowrap">
                <tr>
                    <th class="bg-gray-300 p-2 text-center text-gray-900">#</th>
                    <th class="bg-blue-300 p-2 text-left text-gray-900">
                        {{ __('Team') }}
                    </th>
                    <th class="bg-amber-300 p-2 text-left text-gray-900">
                        {{ __('Last game') }}
                    </th>
                    <th
                        class="bg-yellow-200 p-2 text-center text-gray-900"
                        title="{{ __('Last scores') }}"
                    >
                        {{ __('Score') }}
                    </th>
                    <th
                        @class([
                        'bg-green-300 p-2 text-gray-900',
                        'hidden sm:table-cell' => ! $show_full_table
                        ])
                    >
                        <!-- svg.thumbs-up-solid -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"
                            class="mb-1 inline-block h-5 w-5 fill-green-600"
                        >
                            <path
                                d="M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2l144 0c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48l-97.5 0c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3l0-38.3 0-48 0-24.9c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192l64 0c17.7 0 32 14.3 32 32l0 224c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32L0 224c0-17.7 14.3-32 32-32z"
                            />
                        </svg>
                    </th>
                    <th
                        @class([
                        'bg-red-200 p-2 text-gray-900',
                        'hidden sm:table-cell' => ! $show_full_table
                        ])
                    >
                        <!-- svg.thumbs-down-solid -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"
                            class="mb-1 inline-block h-5 w-5 fill-red-600"
                        >
                            <path
                                d="M313.4 479.1c26-5.2 42.9-30.5 37.7-56.5l-2.3-11.4c-5.3-26.7-15.1-52.1-28.8-75.2l144 0c26.5 0 48-21.5 48-48c0-18.5-10.5-34.6-25.9-42.6C497 236.6 504 223.1 504 208c0-23.4-16.8-42.9-38.9-47.1c4.4-7.3 6.9-15.8 6.9-24.9c0-21.3-13.9-39.4-33.1-45.6c.7-3.3 1.1-6.8 1.1-10.4c0-26.5-21.5-48-48-48l-97.5 0c-19 0-37.5 5.6-53.3 16.1L202.7 73.8C176 91.6 160 121.6 160 153.7l0 38.3 0 48 0 24.9c0 29.2 13.3 56.7 36 75l7.4 5.9c26.5 21.2 44.6 51 51.2 84.2l2.3 11.4c5.2 26 30.5 42.9 56.5 37.7zM32 384l64 0c17.7 0 32-14.3 32-32l0-224c0-17.7-14.3-32-32-32L32 96C14.3 96 0 110.3 0 128L0 352c0 17.7 14.3 32 32 32z"
                            />
                        </svg>
                    </th>
                    <th
                        @class([
                        'bg-green-300 p-2 text-gray-900',
                        'hidden lg:table-cell' => ! $show_full_table
                        ])
                    >
                        <!-- svg.square-plus-solid -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"
                            class="mb-1 inline-block h-5 w-5 fill-green-600"
                        >
                            <path
                                d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zM200 344l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"
                            />
                        </svg>
                    </th>
                    <th
                        @class([
                        'bg-red-200 p-2 text-gray-900',
                        'hidden lg:table-cell' => ! $show_full_table
                        ])
                    >
                        <!-- svg.square-minus-solid -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 448 512"
                            class="mb-1 inline-block h-5 w-5 fill-orange-500"
                        >
                            <path
                                d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32zm88 200l144 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-144 0c-13.3 0-24-10.7-24-24s10.7-24 24-24z"
                            />
                        </svg>
                    </th>
                    <th
                        title="{{ __('Percentage') }}"
                        @class([
                        'bg-purple-300 p-2 text-gray-900',
                        'hidden md:table-cell' => ! $show_full_table
                        ])
                    >
                        <!-- svg.percentage-solid -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 384 512"
                            class="mb-1 inline-block h-5 w-5 fill-indigo-500"
                        >
                            <path
                                d="M374.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-320 320c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l320-320zM128 128A64 64 0 1 0 0 128a64 64 0 1 0 128 0zM384 384a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"
                            />
                        </svg>
                    </th>
                    <th
                        title="{{ __('Number of games participated') }}"
                        @class([
                        'bg-indigo-300 p-2 text-gray-900',
                        'hidden md:table-cell' => ! $show_full_table
                        ])
                    >
                        <!-- svg.champagne-glass-solid -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 640 512"
                            class="mb-1 inline-block h-5 w-5 fill-blue-800"
                        >
                            <path
                                d="M155.6 17.3C163 3 179.9-3.6 195 1.9L320 47.5l125-45.6c15.1-5.5 32 1.1 39.4 15.4l78.8 152.9c28.8 55.8 10.3 122.3-38.5 156.6L556.1 413l41-15c16.6-6 35 2.5 41 19.1s-2.5 35-19.1 41l-71.1 25.9L476.8 510c-16.6 6.1-35-2.5-41-19.1s2.5-35 19.1-41l41-15-31.3-86.2c-59.4 5.2-116.2-34-130-95.2L320 188.8l-14.6 64.7c-13.8 61.3-70.6 100.4-130 95.2l-31.3 86.2 41 15c16.6 6 25.2 24.4 19.1 41s-24.4 25.2-41 19.1L92.2 484.1 21.1 458.2c-16.6-6.1-25.2-24.4-19.1-41s24.4-25.2 41-19.1l41 15 31.3-86.2C66.5 292.5 48.1 226 76.9 170.2L155.6 17.3zm44 54.4l-27.2 52.8L261.6 157l13.1-57.9L199.6 71.7zm240.9 0L365.4 99.1 378.5 157l89.2-32.5L440.5 71.7z"
                            />
                        </svg>
                    </th>
                </tr>
            </thead>
            <tbody class="whitespace-nowrap">
                @foreach ($scores as $score)
                    @if (!$score->get('played'))
                        <div class="box-rounded-danger m-5">
                            <h3 class="center">{{ __('No games yet') }}</h3>
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
                            <td
                                class="bg-gray-200 p-2 text-center text-gray-900"
                                title="{{ __('Your current position') }}"
                            >
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
                                <a
                                    href="{{ route('teams.show', ['team' => $score->get('team')]) }}"
                                    class="link"
                                    wire:navigate
                                >
                                    {{ $score->get('team')->name }}
                                </a>
                            </td>
                            <td
                                class="bg-amber-200 p-2 text-gray-900"
                                title="{{ __('Last played Team') }} ({{ __('week') }} {{ $played_weeks }})"
                            >
                                <a
                                    href="{{ route('teams.show', ['team' => $score->get('played')]) }}"
                                    class="link"
                                    wire:navigate
                                >
                                    {{ $score->get('played')->name }}
                                </a>
                            </td>
                            <td
                                @class([
                                'p-2 text-center',
                                'bg-green-100' => $score_id == $score->get('id')
                                ])
                            >
                                @if ($score->get('last_result') === 'not in')
                                    <span class="text-orange-600"><i>not in</i></span>
                                @elseif ($score->get('last_result') === 'BYE')
                                    <span class="text-gray-600">BYE</span>
                                @else
                                    <div class="flex items-center justify-center space-x-2">
                                        <div
                                            @class([
                                            'text-lg font-semibold text-green-700' => $score1 > 7,
                                            ])
                                        >
                                            {{ $score1 }}
                                        </div>
                                        <div>
                                            <!-- svg.minus-solid -->
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 448 512"
                                                class="inline-block h-3 w-3 fill-gray-600"
                                            >
                                                <path
                                                    d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"
                                                />
                                            </svg>
                                        </div>
                                        <div
                                            @class([
                                            'text-lg font-semibold text-green-700' => $score2 > 7,
                                            ])
                                        >
                                            {{ $score2 }}
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td
                                @class([
                                'bg-green-200 p-2 text-center text-gray-900',
                                'hidden sm:table-cell' => ! $show_full_table
                                ])
                                title="{{ __('Daily games won') }}"
                            >
                                {{ $score->get('won') }}
                            </td>
                            <td
                                @class([
                                'bg-red-100 p-2 text-center text-gray-900',
                                'hidden sm:table-cell' => ! $show_full_table
                                ])
                                title="{{ __('Daily games lost') }}"
                            >
                                {{ $score->get('lost') }}
                            </td>
                            <td
                                @class([
                                'bg-green-200 p-2 text-center text-gray-900',
                                'hidden lg:table-cell' => ! $show_full_table
                                ])
                                title="{{ __('Total games won') }}"
                            >
                                {{ $score->get('for') }}
                            </td>
                            <td
                                @class([
                                'bg-red-100 p-2 text-center text-gray-900',
                                'hidden lg:table-cell' => ! $show_full_table
                                ])
                                title="{{ __('Total games lost') }}"
                            >
                                {{ $score->get('against') }}
                            </td>
                            <td
                                @class([
                                'bg-purple-100 p-2 text-center text-gray-900',
                                'hidden md:table-cell' => ! $show_full_table
                                ])
                                title="{{ __('Percentage') }}"
                            >
                                {{ $score->get('percentage') }}%
                            </td>
                            <td
                                @class([
                                'bg-indigo-100 p-2 text-center text-gray-900',
                                'font-bold' => $score->get('max_games') === $score->get('games_played'),
                                'hidden md:table-cell' => ! $show_full_table
                                ])
                                title="{{ $score->get('games_played') }} {{ __('games participated') }}"
                            >
                                {{ $score->get('games_played') }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    @script
        <script>
            let echoPublicChannel = window.Echo.channel('live-score');
            let ablyPublicChannelName = echoPublicChannel.name;
            console.log(ablyPublicChannelName);
        </script>
    @endscript
</div>

@props(['event', 'matrix', 'i', 'pg', 'home', 'switches'])
@php
    $games = $event->scoreTable($home, $i);
    $game = null;
    // this check is needed to enable the win checkbox for the final game, only if all 4 players are selected
    $has_complete_final_game = $event->checkIfAllLastGamePositionsSelected();
@endphp

<div
    @class([
    'flex',
    'justify-end' => $home,
    'justify-start' => !$home,
    'flex-row-reverse' => ! $home,
    ])
>
    <div class="grow">
        <div
            @class([
            'flex flex-col space-y-2 md:flex-row md:flex-nowrap md:space-y-0',
            'justify-end' => $home,
            'justify-start' => ! $home,
            'rounded-lg border border-neutral-400 bg-neutral-100 p-1' => $i % 2 == $home && ! $switches->get('confirmed') && $i > $pg,
            ])
        >
            @foreach ($games as $game)
                <div
                    @class([
                    'flex items-center',
                    'flex-row-reverse' => ! $home,
                    ])
                    wire:key="game-{{ $game->id }}"
                >
                    @if ($event->confirmed || auth()->guest() || auth()->user()->cannot('update', $game->event))
                        <div
                            @class([
                            'mx-2',
                            'rounded-lg border border-green-500 bg-green-100 px-2' => $switches->get('games')?->where('position', $game->position)->whereStrict('win', true)->where('player_id', $game->player_id)->count(),
                            'rounded-lg border border-yellow-500 bg-yellow-100 px-2' => $switches->get('games')?->where('position', $game->position)->whereStrict('win', false)->where('player_id', $game->player_id)->count(),
                            ])
                        >
                            {{ $game->player?->user->name }}
                        </div>
                    @else
                        @if (is_null($game->win))
                            <div
                                @class([
                                'flex flex-col md:flex-nowrap md:items-center',
                                'md:flex-row' => $home && $i % 5 !== 0,
                                'md:flex-row-reverse' => !$home && $i % 5 !== 0,
                                'space-x-1 lg:flex-row' => $home && $i % 5 === 0,
                                'space-x-1 lg:flex-row-reverse' => !$home && $i % 5 === 0,
                                ])
                            >
                                <label
                                    class="mx-2 text-sm text-gray-500"
                                    for="item-{{ $game->id }}"
                                    @style(['display: none' => $i === 15])
                                >
                                    {{ ($home ? 'Home' : 'Visit') }} {{ $game->player_position }}
                                </label>
                                <select
                                    id="item-{{ $game->id }}"
                                    wire:change="playerChanged($event.target.value, {{ $game->id }})"
                                    @class(['ml-2' => $i === 15 && $home, 'mr-2' => $i === 15 && !$home])
                                >
                                    @if ($i === 15 && !$game->player_id)
                                        <option value="0">--{{ __('select') }}--</option>
                                    @endif

                                    @foreach ($matrix as $position)
                                        <option
                                            wire:key="position-{{ $position->id }}"
                                            value="{{ $position->player->id }}"
                                            @selected($game->player_id === $position->player->id)
                                        >
                                            {{ $position->player->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="mx-2">
                                {{ $game->player->name }}
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="flex items-center">
        @if ($event->confirmed || auth()->guest() || auth()->user()->cannot('update', $game->event))
            @if ($game->win)
                <x-svg.check-solid color="fill-green-600" size="5" />
            @else
                <span class="h-5 w-5"></span>
            @endif
        @else
            <div class="mx-3">
                <label wire:replace>
                    <input
                        type="checkbox"
                        wire:key="win-{{ $game->id }}-{{ $i }}"
                        wire:change="scoreGiven({{ $game->id }})"
                        wire:target="scoreGiven({{ $game->id }})"
                        @class([
                        'h-6 w-6',
                        'mt-4 md:mt-0' => $i % 5 !== 0 && $game->win === null,
                        'cursor-pointer' => $game->position === 15 && $has_complete_final_game,
                        'cursor-not-allowed bg-indigo-100' => $game->position === 15 && !$has_complete_final_game,
                        'text-green-600' => $game->win,
                        'bg-red-50' => $game->win === false])
                        @checked($game->win)
                        @disabled($game->position === 15 && !$has_complete_final_game)
                    />
                </label>
            </div>
        @endif
    </div>
</div>

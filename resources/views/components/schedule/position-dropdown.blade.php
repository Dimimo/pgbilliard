@props(['event', 'matrix', 'i', 'home', 'game_win_id', 'game_lost_id'])
@php
    $games = $event->games()
    ->where([
                ['games.event_id', $event->id],
                ['games.position', $i],
                ['games.home', $home]
            ])
    ->join('schedules', 'games.schedule_id', '=', 'schedules.id')
    ->select('games.*', 'schedules.player as player_position')
    ->orderBy('games.position')
    ->get();
@endphp

<div @class([
            'flex',
            'justify-end' => $home,
            'justify-start' => !$home,
        ])>
    <div class="flex flex-col md:flex-row md:flex-nowrap space-y-2 md:space-y-0">
        @foreach($games as $game)
            <div @class([
                'flex items-center',
                'flex-row-reverse' => ! $home,
                'border border-green-500 rounded-lg bg-green-100 p-1' => $game->id === $game_win_id,
                'border border-yellow-500 rounded-lg bg-yellow-100 p-1' => $game->id === $game_lost_id,
            ])
                 wire:key="game-{{$game->id}}"
            >
                @if($event->confirmed || auth()->guest() || auth()->user()->cannot('update', $game->event))
                    <div class="mx-2">
                        {{ $game->player?->user->name }}
                    </div>
                @else
                    @if(is_null($game->win))
                        <div @class([
                                'flex flex-col md:flex-row md:flex-nowrap md:items-center',
                                'md:flex-row' => $home,
                                'md:flex-row-reverse' => !$home
                            ])
                        >
                            <label class="mx-2 text-sm text-gray-500" for="item-{{$game->id}}" wire:key="item-{{$game->id}}">
                                {{ $home ? 'Home' : 'Visit' }} {{ $game->player_position }}
                            </label>
                            <select
                                id="item-{{$game->id}}"
                                wire:change="playerChanged($event.target.value, {{$game->id}})"
                            >
                                @if ($i === 15 && !$game->player_id)
                                    <option value="0">--{{__('select')}}--</option>
                                @endif
                                @foreach($matrix as $position)
                                    <option
                                        wire:key="position-{{$position->id}}"
                                        value="{{$position->player->id}}"
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

                @if(($loop->last && $home) || ($loop->first && !$home))
                    @if($event->confirmed || auth()->guest() || auth()->user()->cannot('update', $game->event))
                        @if ($game->win)
                            <x-svg.check-solid color="fill-green-600" size="5"/>
                        @else
                            <span class="h-5 w-5"></span>
                        @endif
                    @else
                        @php
                            // this check is needed to enable the win checkbox for the final game, only if all 4 players are selected
                            $has_complete_final_game = $event->games()->wherePosition(15)->has('player')->count() === 4;
                        @endphp
                        <div class="mx-3">
                            <label wire:replace>
                                <input
                                    type="checkbox"
                                    wire:key="win-{{$game->id}}-{{$i}}"
                                    wire:change="scoreGiven({{$game->id}})"
                                    wire:target="scoreGiven({{$game->id}})"
                                    @class([
                                        'h-6 w-6',
                                        'mt-4 md:mt-0' => $i%5 !== 0 && $game->win === null,
                                        'cursor-pointer' => $game->position === 15 && $has_complete_final_game,
                                        'cursor-not-allowed bg-indigo-100' => $game->position === 15 && !$has_complete_final_game,
                                        'text-green-600' => $game->win,
                                        'bg-red-50' => $game->win === false]
                                    )
                                    @checked($game->win)
                                    @disabled($game->position === 15 && !$has_complete_final_game)
                                >
                            </label>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>

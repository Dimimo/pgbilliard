@props(['event', 'matrix', 'i', 'home'])
@php
    $games = $event->games()
    ->where([
                ['games.event_id', $event->id],
                ['games.position', $i],
                ['games.home', $home]
            ])
    ->join('schedules', 'games.schedule_id', '=', 'schedules.id')
    ->select('games.*', /*'users.name',*/ 'schedules.player as player_position')
    ->orderBy('games.position')
    ->get();
@endphp

<div @class(['flex flex-nowrap', 'justify-end' => $home])>
    @foreach($games as $game)
        <div @class([
                'flex items-center',
                'flex-row-reverse' => ! $home,
            ])
             wire:key="game-{{$game->id}}"
        >
            @if($event->confirmed || auth()->guest() || auth()->user()->cannot('update', $game->event))
                <div class="mx-2">
                    {{ $game->player?->user->name }}
                </div>
            @else
                @if(is_null($game->win))
                    <label class="mx-2 text-sm text-gray-500" for="item-{{$game->id}}" wire:key="item-{{$game->id}}">
                        @if($loop->count == 1)
                            {{ $home ? 'Home' : 'Visit' }} {{ $game->player_position }}
                        @endif
                    </label>
                    <select
                        id="item-{{$game->id}}"
                        wire:change="playerChanged($event.target.value, {{$game->id}})"
                    >
                        @if ($i === 15)
                            <option value="">--select--</option>
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
                    @elseif ($game->event->completed)
                        <x-svg.xmark-solid color="fill-red-600" size="4"/>
                    @else
                        <span class="w-5 h-5"></span>
                    @endif
                @else
                    <div class="mx-3">
                        <label wire:replace>
                            <input
                                id=win-{{$game->id}}-{{$i}}"
                                type="checkbox"
                                wire:key="win-{{$game->id}}-{{$i}}"
                                wire:change="scoreGiven({{$game->id}})"
                                wire:target="scoreGiven({{$game->id}})"
                                @class(['h-6 w-6', 'cursor-pointer', 'text-green-600' => $game->win, 'bg-red-50' => $game->win === false])
                                @checked($game->win)
                            >
                        </label>
                    </div>
                @endif

            @endif
        </div>
    @endforeach
</div>

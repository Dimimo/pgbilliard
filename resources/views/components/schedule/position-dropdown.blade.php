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
            @if($event->confirmed)
                <div class="mx-2">
                    {{ $game->player->name }}
                </div>
            @else
                @if(is_null($game->win))
                    <label class="mx-2 text-sm text-gray-500" for="item-{{$game->id}}" wire:key="item-{{$game->id}}">
                        @if($loop->count == 1)
                            {{ $home ? 'Home' : 'Visit' }} {{ $game->player_position }}
                        @endif
                    </label>
                    <select id="item-{{$game->id}}">
                        @if ($i === 15)
                            <option value="">--select--</option>
                        @endif
                        @foreach($matrix as $player)
                            <option
                                wire:key="position-{{$player->id}}"
                                wire:click="playerChanged({{$player->id}}, {{$game->id}})"
                                @selected($game->player_id === $player->id)
                            >
                                {{ $player->name }}
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
                @if($event->confirmed)
                    @if ($game->win)
                        <x-svg.check-solid color="fill-green-600" size="5"/>
                    @else
                        <x-svg.xmark-solid color="fill-red-600" size="4"/>
                    @endif
                @else
                    <div class="mx-3">
                        <label wire:replace>
                            <input
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

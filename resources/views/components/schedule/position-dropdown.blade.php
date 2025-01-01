@props(['event', 'matrix', 'i', 'home'])
@php
    $games = $event->games()
    ->where([
                ['games.event_id', $event->id],
                ['games.position', $i],
                ['games.home', $home]
            ])
    //->join('players', 'games.player_id', '=', 'players.id')
    //->join('users', 'users.id', '=', 'players.user_id')
    ->join('schedules', 'games.schedule_id', '=', 'schedules.id')
    ->select('games.*', /*'users.name',*/ 'schedules.player as player_position')
    ->orderBy('games.position')
    ->get();
    /*if ($i === 15) {
        dd($games);
    }*/
    //dd($event->games()->orderBy('games.position')->get());
@endphp

<div @class(['flex flex-nowrap', 'justify-end' => $home])>
    @foreach($games as $game)
        <div @class([
                'flex items-center',
                'flex-row-reverse' => ! $home,
            ])
             wire:key="game-{{$game->id}}"
        >
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
                        @selected($game->player_id === $player->id)
                        wire:key="position-{{$player->id}}"
                        wire:click="playerChanged({{$player->id}}, {{$game->id}})"
                    >
                        {{ $player->name }}
                    </option>
                @endforeach
            </select>
            @if(($loop->last && $home) || ($loop->first && !$home))
                <div class="mx-3">
                    <label>
                        <input
                            type="checkbox"
                            @class(['h-6 w-6', 'cursor-pointer' => $game->win, 'cursor-not-allowed' => $game->win === false])
                            class="h-6 w-6 cursor-pointer"
                            @checked($game->win)
                            @disabled($game->win === false)
                            wire:key="win-{{$game->id}}-{{$i}}"
                            wire:change="scoreGiven({{$game->id}})"
                        >
                    </label>
                </div>
            @endif
        </div>
    @endforeach
</div>

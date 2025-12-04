@if (auth()->check() && auth()->user()->isSuperAdmin())
    <h1>Testing</h1>

    @php
        $events = App\Models\Event::all();
    @endphp

    @foreach ($events as $event)
        @php
            $games = $event->games()->whereNotNull('player_id')->with('player.user')->orderBy('event_id')->get();
        @endphp

        @if ($games->count() > 0)
            @foreach ($games as $game)
                @if ($game->player->user_id !== $game->user_id)
                    @php
                        $game->update(['user_id' => $game->player->user_id])
                    @endphp

                    <div>{{ $game->player->user->name }} --- {{ $game->user->name }}</div>
                    <div>
                        <strong>{{ $game->player->user_id }} --- {{ $game->user_id }}</strong>
                    </div>
                @endif
            @endforeach
        @endif
    @endforeach
@else
    <h1>Booga booga!</h1>
@endif

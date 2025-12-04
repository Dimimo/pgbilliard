@if (auth()->check() && auth()->user()->isSuperAdmin())
    <hi>Testing</hi>

    @php
        $events = App\Models\Event::where('date_id', '>=', 344)->get();
    @endphp

    @foreach ($events as $event)
        @php
            $games = $event->games()->wherePosition(15)->whereNotNull('player_id')->whereNull('user_id')->with('player.user')->orderBy('event_id')->get();
        @endphp

        @if ($games->count() > 0)
            @foreach ($games as $game)
                @php
                    $game->update(['user_id' => $game->player->user_id])
                @endphp

                <div>
                    Player {{ $game->player_id }} has user id {{ $game->player->user_id }} and
                    name
                    {{ $game->player->user->name }}
                </div>
            @endforeach
        @endif
    @endforeach
@else
    <h1>Booga booga!</h1>
@endif

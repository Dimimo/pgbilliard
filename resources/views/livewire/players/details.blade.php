<div>
    <x-player.participation :team="$player->team" :player="$player" :rank="$rank"/>

    <x-forms.sub-title title="{{__('Individual Games and Results')}}">
        @foreach ($games as $game)
            @php
                if ($game->event->date->date != $date) {
                    $date = $game->event->date->date;
                    $new_date = true;
                } else {
                    $new_date = false;
                }
                $opponents = $game->event
                    ->games()
                    ->wherePosition($game->position)
                    ->where('team_id', '<>', $game->team_id)
                    ->where('player_id', '<>', $game->player->id)
                    ->with('player.user')
                    ->get();
                $position = $opponents->count() === 2
                    ? ' - double with ' . $game->event->games()->wherePosition($game->position)->where('team_id', $game->team_id)->where('player_id', '<>', $game->player->id)->first()?->player->name
                    : ' - single';
            @endphp

            <div class="p-2">
                @if ($new_date || $loop->first)
                    <div
                        class="my-2 rounded-lg border border-indigo-400 bg-indigo-50 p-2 text-center font-bold"
                    >
                        {{ $game->event->date->date->format('jS \o\f M Y') }} @
                        {{ $game->event->venue->name }}
                        <span class="font-normal">
                            ({{ $game->event->team_1->name }} vs {{ $game->event->team_2->name }})
                        </span>
                        <div class="text-sm text-gray-500">
                            {{ $player->name }} {{ __('played for') }} {{ $game->team->name }}
                        </div>
                    </div>
                @endif

                <div class="ml-4 flex items-center justify-start space-x-2">
                    <div class="w-5">
                        @if ($game->win)
                            <x-svg.check-solid color="fill-green-600" size="5"/>
                        @else
                            <x-svg.xmark-solid color="fill-red-600" size="4"/>
                        @endif
                    </div>

                    <div>
                        {{ Arr::join($opponents->pluck('player.user.name')->toArray(), ' & ') }}
                    </div>
                    <div class="text-sm">(game {{ $game->position }} {{ $position }})</div>
                </div>
            </div>
        @endforeach
    </x-forms.sub-title>
</div>

<div>
    <x-player.participation :team="$player->team" :player="$player" :rank="$rank" />

    <x-forms.sub-title title="{{__('Individual Games and Results')}}">
        @foreach ($games as $game)
            @php
                if ($game->event->date->date != $date) {
                    $date = $game->event->date->date;
                    $new_date = true;
                } else {
                    $new_date = false;
                }
                $opponents = (new \App\Models\Game())->where([['event_id', $game->event_id], ['position', $game->position]])->with('user')->get();
                $position = $opponents->where('team_id', '<>', $game->team_id)->count() === 2
                    ? ' - double with ' . $opponents->where('team_id', $game->team_id)->where('player_id', '<>', $game->player->id)->first()?->user->name
                    : ' - single';
            @endphp

            <div class="p-2">
                @if ($new_date || $loop->first)
                    <div
                        @class([
                        "my-2 flex flex-col rounded-lg border p-2 text-center font-bold",
                        "border-indigo-400 bg-indigo-50" => ! $game->event->date->regular,
                        "border-green-500 bg-green-50" => $game->event->date->regular,
                        ])
                    >
                        <div class="flex justify-center">
                            <a
                                href="{{ route('schedule.event', ['event' => $game->event]) }}"
                                class="link text-blue-800"
                                wire:navigate
                            >
                                {{ $game->event->date->date->format('jS \o\f M Y') }} @
                                {{ $game->event->venue->name }}
                            </a>
                        </div>
                        <div class="text-normal font-normal italic text-gray-500">
                            {{ $player->name }} {{ __('played for') }} {{ $game->team->name }}
                        </div>
                        <div class="font-normal">
                            {{ $game->event->team_1->name }} vs {{ $game->event->team_2->name }}
                        </div>
                        @if ($game->event->date->regular)
                            <di class="mb-2 text-lg text-green-700">
                                {{ str::apa($game->event->date->title) }}
                            </di>
                        @endif
                    </div>
                @endif

                <div class="ml-4 flex items-center justify-start space-x-2">
                    <div class="w-5">
                        @if ($game->win)
                            <x-svg.check-solid color="fill-green-600" size="5" />
                        @else
                            <x-svg.xmark-solid color="fill-red-600" size="4" />
                        @endif
                    </div>

                    <div>
                        {{ Arr::join($opponents->where('team_id', '<>', $game->team_id)->pluck('user.name')->toArray(), ' & ') }}
                    </div>
                    <div class="text-sm">(game {{ $game->position }} {{ $position }})</div>
                </div>
            </div>
        @endforeach
    </x-forms.sub-title>
</div>

@props(['event', 'players', 'matrix', 'place', 'can_update_players'])
<div class="grid h-full content-between">
    <div>
        <div @class([
                'mb-4 flex flex-row items-center space-x-2 text-lg',
                'justify-end text-indigo-70' => $place === 'home',
                'justify-start text-green-600' => $place === 'visit',
            ])>
            <x-forms.action-message on="player-updated-home">
                updated
            </x-forms.action-message>
            <div>{{ Str::ucfirst($place) }} team</div>
        </div>
        @for($i=1;$i<=$players->count();$i++)
            <div @class([
                'mb-1 flex items-center justify-end',
                'flex-row-reverse' => $place === 'visit',
            ])
                 {{--wire:key="player-{{$players->first()->team->id}}-{{count($matrix)}}"--}}
            >
                @if ($can_update_players && Gate::authorize('update', $event))
                    <div class="mx-2">
                        @if ($i <= 4)
                            {{Str::ucfirst($place)}} {{ $i }}
                        @else
                            Reserve
                        @endif
                    </div>
                    <label>
                        <select class="text-sm">
                            <option
                                value=""
                                wire:click="playerSelected(0, {{$i}}, '{{$place}}')"
                            >
                                -- select --
                            </option>
                            @foreach($players as $player)
                                <option
                                    wire:key="selected-{{$i}}-{{count($matrix)}}"
                                    wire:click="playerSelected({{$player->id}}, {{$i}}, '{{$place}}')"
                                    @selected(array_key_exists($i, $matrix) && $matrix[$i]->id === $player->id)
                                    value="{{$player->id}}"
                                >
                                    {{$player->name}}
                                </option>
                            @endforeach
                        </select>
                    </label>
                @else
                    {{$matrix[$i]->name}}
                @endif
            </div>
        @endfor
    </div>
    @if ($can_update_players && Gate::authorize('update', $event))
        <div @class([
                'flex',
                'justify-end' => $place === 'home',
                'justify-start' => $place === 'visit',
            ])>
            <button
                wire:click="scheduleReset(1)"
                class="mt-4 w-min whitespace-nowrap rounded-full border-2 border-green-500 bg-green-100 hover:bg-green-200 px-4 py-2">
                <x-svg.xmark-solid color="fill-red-600" size="5" padding="mr-1"/>
                Reset the schedule
            </button>
        </div>
    @endif
</div>

{{--
{{ $player->name }} ({!! trans_choice('plural.games', $format->checkGameNumbers($player->id, true)) !!})
--}}

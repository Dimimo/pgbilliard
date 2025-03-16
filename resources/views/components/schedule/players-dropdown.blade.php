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
                 wire:key="player-{{$players->first()->team->id}}-{{$matrix->count()}}"
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
                        <select
                            class="text-sm"
                            wire:change="playerSelected($event.target.value, {{$i}}, '{{$place}}')"
                        >
                            <option value="0">
                                -- select --
                            </option>
                            @foreach($players as $player)
                                <option
                                    wire:key="selected-{{$i}}-{{$matrix->count()}}"
                                    @selected($matrix->where('rank', $i)->first()?->player->id === $player->id)
                                    value="{{$player->id}}"
                                >
                                    {{$player->name}}
                                </option>
                            @endforeach
                        </select>
                    </label>
                @elseif ($matrix->where('rank', $i)->count())
                    @if($matrix->where('rank', $i)->first()->home)
                        <div @class([
                            'mb-1 flex items-center justify-end',
                            'flex-row-reverse' => $place === 'visit',
                        ])>
                            <div class="mx-2 text-lg">{{$matrix->where('rank', $i)->first()->player?->name}}</div>
                            <div class="inline-flex items-center rounded-full border border-indigo-400 bg-indigo-100 px-2 py-1 font-bold leading-4">
                                {{$i}}
                            </div>
                        </div>
                    @else
                        <div class="mx-2 text-lg">{{$matrix->where('rank', $i)->first()->player?->name}}</div>
                        <div class="inline-flex items-center rounded-full border border-green-500 bg-green-100 px-2 py-1 font-bold leading-4">
                            {{$i}}
                        </div>
                    @endif
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
                wire:click="scheduleReset('{{ $place }}')"
                class="mt-4 w-min whitespace-nowrap rounded-full border-2 border-green-500 bg-green-100 px-4 py-2 hover:bg-green-200">
                <x-svg.xmark-solid color="fill-red-600" size="5" padding="mr-1"/>
                Reset the schedule
            </button>
        </div>
    @endif
</div>

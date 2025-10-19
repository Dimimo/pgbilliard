@props(['event', 'players', 'matrix', 'place', 'switches'])

<div class="grid h-full content-between">
    <div>
        <div
            @class([
            'mb-4 flex flex-row items-center space-x-2 text-lg',
            'text-indigo-70 justify-end' => $place === 'home',
            'justify-start text-green-600' => $place === 'visit',
            ])
        >
            <x-forms.action-message
                on="player-updated-{{$place}}"
                @class(['ml-2 order-last' => $place === 'visit'])
            >
                {{ __('Updated') }}
            </x-forms.action-message>
            <div>{{ Str::ucfirst($place) }} {{ __('Team') }}</div>
        </div>
        @if (!empty($players))
            @for ($i=1;$i<=$players->count();$i++)
                @php
                    $old_position_player_id = $matrix->where('rank', $i)->first()?->player->id;
                @endphp

                <div
                    @class([
                    'mb-1 flex items-center justify-end',
                    'flex-row-reverse' => $place === 'visit',
                    ])
                    wire:key="player-{{ $players->first()->team->id }}-{{ $matrix->count() }}"
                >
                    @if ($switches->get('canUpdatePlayers') && Gate::authorize('update', $event))
                        <div class="mx-2">
                            @if ($i <= 4)
                                {{ Str::ucfirst($place) }} {{ $i }}
                            @else
                                {{ __('Reserve') }}
                            @endif
                        </div>
                        <label>
                            <select
                                class="text-sm"
                                wire:change="playerSelected($event.target.value, {{ $i }}, '{{ $place }}', {{ $old_position_player_id }})"
                            >
                                <option value="0">-- {{ __('select') }} --</option>
                                @foreach ($players as $player)
                                    <option
                                        wire:key="selected-{{ $i }}-{{ $matrix->count() }}"
                                        @selected($old_position_player_id === $player->id)
                                        value="{{ $player->id }}"
                                    >
                                        {{ $player->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                    @elseif ($matrix->where('rank', $i)->count())
                        @if ($matrix->where('rank', $i)->first()->home)
                            <div class="mx-2 text-lg">
                                {{ $matrix->where('rank', $i)->first()->player?->name }}
                            </div>
                            <div
                                class="inline-flex items-center rounded-full border border-indigo-400 bg-indigo-100 px-2 py-1 font-bold leading-4"
                            >
                                {{ $i }}
                            </div>
                        @else
                            <div class="mx-2 text-lg">
                                {{ $matrix->where('rank', $i)->first()->player?->name }}
                            </div>
                            <div
                                class="inline-flex items-center rounded-full border border-green-500 bg-green-100 px-2 py-1 font-bold leading-4"
                            >
                                {{ $i }}
                            </div>
                        @endif
                    @endif
                </div>
            @endfor
        @endif
    </div>
    @if ($switches->get('canUpdatePlayers') && Gate::authorize('update', $event))
        <div
            @class([
            'flex',
            'justify-end' => $place === 'home',
            'justify-start' => $place === 'visit',
            ])
        >
            <button
                wire:click="scheduleReset('{{ $place }}')"
                class="mt-4 w-min whitespace-nowrap rounded-full border-2 border-green-500 bg-green-100 px-4 py-2 hover:bg-green-200"
            >
                @if ($event->games()->count() > 4)
                    <x-svg.xmark-solid color="fill-red-600" size="5" padding="mr-1" />
                    {{ __('Reset the schedule') }}
                @else
                    <x-svg.list-ul-solid color="fill-green-600" size="4" padding="mb-1 mr-1" />
                    {{ __('Select a different format') }}
                @endif
            </button>
        </div>
    @endif
</div>

<div>
    <div class="my-2 flex justify-center">
        <x-forms.action-message on="format-chosen">
            {{__('Your favorite format is selected')}}
        </x-forms.action-message>
    </div>
    @if($choose_format)
        @can('update', $event)
            <div class="my-8">
                <x-forms.sub-title title="{{__('Choose a day games format')}}">
                    <div class="flex justify-center">
                        @foreach(\App\Models\Format::orderBy('name')->get() as $f)
                            <button
                                class="m-2 w-full rounded-lg border border-green-500 bg-green-100 p-2 text-left"
                                wire:click="formatChosen({{ $f->id }})"
                            >
                                <div class="text-lg">{{ $f->name }}</div>
                                <div class="text-sm">{{ $f->details }}</div>
                            </button>
                        @endforeach
                    </div>
                </x-forms.sub-title>
            </div>
        @endcan
    @else

        <div class="grid grid-flow-row grid-cols-8 items-center justify-items-center gap-2">
            @if(! $confirmed)
                <div
                    class="col-span-8 mb-4 mx-2 md:mx-0 h-auto rounded-lg border-2 border-indigo-400 bg-indigo-100 p-2 pt-2 text-center text-xl"
                >
                    {{__('The format used is the')}} <span class="font-bold">{{ $format->name }}</span>

                    @if ($can_update_players && auth()->check() && auth()->user()->can('update', $event))
                        <div class="m-2 text-center text-sm">
                            It happens, if you move the players around, the schedule goes haywire. <br>
                            Simply
                            <x-svg.xmark-solid color="fill-red-600" size="4" padding="ml-1"/>
                            reset the schedule and start again. No big deal! <br>
                            <span class="font-bold">Check the schedule first before starting the game!</span> <br>
                            After entering the first score, the player order and reserves are locked<br>
                            You can change any player later on in the schedule itself.
                        </div>
                    @endif
                </div>
            @endif

            <div class="col-span-4 h-full w-full bg-blue-50 p-4 text-right">
                <x-schedule.players-dropdown
                    :key="'home-matrix' . '-' . $home_matrix?->count()"
                    :event="$event"
                    :players="$home_players"
                    place="home"
                    :matrix="$home_matrix"
                    :can_update_players="$can_update_players"

                />
            </div>
            <div class="col-span-4 h-full w-full bg-green-50 p-4 text-left">
                <x-schedule.players-dropdown
                    :key="'visit-matrix' . '-' . $visit_matrix?->count()"
                    :event="$event"
                    :players="$visit_players"
                    place="visit"
                    :matrix="$visit_matrix"
                    :can_update_players="$can_update_players"
                />
            </div>

            @foreach($rounds as $i => $round)
                @php
                    $j = $i+5;
                    $pg = $event->score1 + $event->score2;
                @endphp

                @for($i;$i<$j;$i++)
                    @if($i%5)
                        @if(in_array($i, [1,6,11]))
                            <div class="col-span-8 h-12 w-full bg-green-100 pt-2 text-center text-xl">
                                {{ $round }} {{__('singles')}}
                                <x-forms.action-message on="score-updated">
                                    <div class="text-blue-600">
                                        {{__('Score updated')}}
                                    </div>
                                </x-forms.action-message>
                            </div>
                        @endif
                    @else
                        <div class="col-span-8 h-12 w-full bg-blue-100 pt-2 text-center text-xl">
                            {{ $round }} {{__('doubles')}}
                        </div>
                    @endif
                    <div
                        @class([
                            'col-span-4 w-full p-1 text-right',
                            'bg-neutral-100 border border-neutral-400 rounded-lg' => $i%2 === 1 && ! $confirmed && $i > $pg,
                            ])
                    >
                        <x-schedule.position-dropdown
                            key="home-{{ $i }}"
                            :event="$event"
                            :i="$i"
                            :matrix="$home_matrix"
                            home="1"
                            :game_win_id="$game_win_id"
                            :game_lost_id="$game_lost_id"
                        />
                    </div>
                    <div
                        @class([
                            'col-span-4 w-full p-1',
                            'bg-neutral-100 border border-neutral-700 rounded-lg' => $i%2 === 0 && ! $confirmed && $i > $pg,
                            ])
                    >
                        <div>
                            <x-schedule.position-dropdown
                                key="visit-{{ $i }}"
                                :event="$event"
                                :i="$i"
                                :matrix="$visit_matrix"
                                home="0"
                                :game_win_id="$game_win_id"
                                :game_lost_id="$game_lost_id"
                            />
                        </div>
                    </div>
                @endfor
            @endforeach

            @if($event->score1 + $event->score2 === 15)
                <div
                    class="col-span-8 mt-8 flex w-min flex-col justify-center whitespace-nowrap rounded-lg border-2 border-green-500 p-2 text-center text-xl space-y-3">
                    <div class="text-2xl">{{__('Final Score')}}:</div>
                    <div>
                        <span @class(['text-green-700' => $event->score1 > 7])>{{ $event->team_1->name }} {{ $event->score1 }}</span>
                        <x-svg.minus-solid color="fill-gray-600" size="3" padding="mx-2"/>
                        <span @class(['text-green-700' => $event->score2 > 7])>{{ $event->score2 }} {{ $event->team_2->name }}</span>
                    </div>
                    @if(! $event->confirmed)
                        @can('update', $event)
                            <div>
                                <button
                                    type="button"
                                    title="Confirm the final score"
                                    class="rounded-lg bg-blue-100 p-2 outline outline-blue-600 hover:bg-green-100 hover:outline-green-600"
                                    wire:click="consolidate()"
                                    wire:confirm="Final score is {{ $event->team_1->name }} {{ $event->score1 }} - {{ $event->score2 }} {{ $event->team_2->name }}\nYou can't change the score after the confirmation."
                                >
                                    {{__('Confirm')}}
                                </button>
                            </div>
                        @endcan
                    @endif
                </div>
            @else
                <div class="fixed bottom-0 z-50">
                    <div class="w-min whitespace-nowrap rounded-t-lg border border-blue-800 bg-yellow-100 p-2 text-xl">
                        <span @class(['text-green-700' => $event->score1 > 7])>{{ $event->team_1->name }} {{ $event->score1 }}</span>
                        <x-svg.minus-solid color="fill-gray-600" size="3" padding="mx-2"/>
                        <span @class(['text-green-700' => $event->score2 > 7])>{{ $event->score2 }} {{ $event->team_2->name }}</span>
                    </div>
                </div>
            @endif

        </div>
    @endif

    @script
    <script>
        let echoPublicChannel = window.Echo.channel('live-score');
        let ablyPublicChannelName = echoPublicChannel.name;
        console.log(ablyPublicChannelName);
    </script>
    @endscript
</div>

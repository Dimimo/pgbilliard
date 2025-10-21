@props(['event', 'switches', 'home_matrix', 'visit_matrix'])

<div class="grid grid-flow-row grid-cols-8 items-center justify-items-center gap-2">
    <!-- start the individual scores table -->

    @foreach ($switches->get('rounds') as $i => $round)
        @php
            $j = $i + 5;
            $pg = $event->score1 + $event->score2;
        @endphp

        @for ($i;$i<$j;$i++)
            @if ($i % 5)
                @if (in_array($i, [1,6,11]))
                    <div class="col-span-8 h-12 w-full bg-green-100 pt-2 text-center text-xl">
                        {{ $round }} {{ __('singles') }}
                        <x-forms.action-message on="score-updated">
                            <div class="text-blue-600">
                                {{ __('Score updated') }}
                            </div>
                        </x-forms.action-message>
                    </div>
                @endif
            @else
                <div class="col-span-8 h-12 w-full bg-blue-100 pt-2 text-center text-xl">
                    {{ $round }} {{ __('doubles') }}
                </div>
            @endif
            <div class="col-span-4 flex w-full justify-end p-1">
                <x-schedule.position-dropdown
                    key="home-{{ $i }}"
                    :event="$event"
                    :i="$i"
                    :pg="$pg"
                    :matrix="$home_matrix"
                    home="1"
                    :switches="$switches"
                />
            </div>
            <div class="col-span-4 flex w-full justify-start p-1">
                <x-schedule.position-dropdown
                    key="visit-{{ $i }}"
                    :event="$event"
                    :i="$i"
                    :pg="$pg"
                    :matrix="$visit_matrix"
                    home="0"
                    :switches="$switches"
                />
            </div>
        @endfor
    @endforeach
</div>

<div>
    <x-title title="Games schedule" subtitle="Season {{ session('cycle') }}" help="calendar"/>

    <x-navigation.main-links-buttons/>

    <div class="relative flex flex-col">
        <div class="px-0 py-2 sm:p-2 md:p-4">
            <div class="flex flex-wrap">

                @foreach ($dates as $date)

                    <div class="w-full px-1 md:w-1/2 lg:w-1/3" wire:key="date_{{ $date->id }}">
                        <div @class([
                                'relative',
                                'grid',
                                'grid-flow-row',
                                'justify-items-center',
                                'auto-rows-max',
                                'gap-y-2',
                                'w-auto',
                                'py-3',
                                'px-6',
                                'text-gray-900',
                                'rounded-t-lg',
                                'bg-green-500' => $date->regular,
                                'bg-teal-500' => ! $date->regular
                            ])>
                            <a
                                href="{{ route('dates.show', ['date' => $date]) }}"
                                class="text-lg !text-white after:!bg-yellow-100 link" title="click for details"
                                wire:navigate
                            >
                                {{ $date->date->format('jS \o\f M Y') }}
                            </a>
                            @if ($date->checkOpenWindowAccess())
                                <div class="text-lg text-yellow-100">
                                    <a
                                        href="{{ route('dates.show', ['date' => $date]) }}"
                                        class="animate-pulse"
                                        wire:navigate
                                    >
                                        {{__('Live update')}}!
                                    </a>
                                </div>
                            @endif
                            @if ($date->title)
                                <div
                                    class="text-center text-xl font-medium {{ $date->regular ? 'text-violet-900' : 'text-gray-900' }}">{{ $date->title }}</div>
                            @endif
                        </div>

                        @if ($date->events && $date->events()->count() > 0)
                            <table class="mb-4 w-full">
                                <thead class="whitespace-nowrap">
                                <tr class="bg-gray-100">
                                    <th class="p-2 text-left text-red-700">{{__('Home Team')}}</th>
                                    <th class="p-2 text-right text-blue-700">{{__('Visitors')}}</th>
                                </tr>
                                </thead>
                                <tbody class="whitespace-nowrap">
                                @foreach ($date->events as $event)

                                    <tr wire:key="event_{{ $event->id }}">
                                        <td @class(['bg-green-50' => $my_team === $event->team_1->id, 'font-semibold' => $event->score1 > 7])>
                                            <div
                                                class="flex justify-between p-1"
                                                wire:click.self="setMyTeam({{ $event->team_1->id }})"
                                            >
                                                <div class="mr-1 text-left text-gray-900">
                                                    <a
                                                        href="{{ route('teams.show', ['team' => $event->team_1]) }}"
                                                        class="link"
                                                        wire:navigate
                                                    >
                                                        {{ $event->team_1->name }}
                                                    </a>
                                                </div>
                                                @if($event->score1 !== null &&  $event->team_2->name !== 'BYE')
                                                    <div
                                                        @class([
                                                            'mr-1',
                                                            'text-green-700' => $event->score1 > 7,
                                                            'text-red-700' => $event->score1 < 8,
                                                        ])
                                                    >
                                                        {{ $event->score1 }}
                                                    </div>
                                                @else
                                                    <div></div>
                                                @endif
                                            </div>
                                        </td>
                                        <td @class(['bg-green-50' => $my_team === $event->team_2->id, 'font-semibold' => $event->score2 > 7])>
                                            <div
                                                class="flex justify-between p-1"
                                                wire:click.prevent="setMyTeam({{ $event->team_2->id }})"
                                            >
                                                @if($event->score2 !== null &&  $event->team_2->name !== 'BYE')
                                                    <div
                                                        @class([
                                                            'ml-1',
                                                            'text-green-700' => $event->score2 > 7,
                                                            'text-red-700' => $event->score2 < 8,
                                                        ])
                                                    >
                                                        {{ $event->score2 }}
                                                    </div>
                                                @else
                                                    <div></div>
                                                @endif
                                                <div class="ml-1 text-right text-gray-900">
                                                    <a
                                                        href="{{ route('teams.show', ['team' => $event->team_2]) }}"
                                                        class="link"
                                                        wire:navigate
                                                    >
                                                        {{ $event->team_2->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @if ($event->team_1->venue_id != $event->venue_id)

                                        <tr>
                                            <td colspan="2" class="text-center font-medium text-red-600">
                                                {{__('Game')}} @ {{ $event->venue->name }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                </tbody>
                            </table>
                        @else
                            <div class="border-x-2 border-b-2 border-green-500 bg-green-100/25 p-2">
                                @can ('create', $date)
                                {{__('There are no games yet')}}, <a
                                        href="{{ route('admin.calendar.update', ['season' => $date->season]) }}"
                                        class="inline-block text-blue-600 link"
                                        wire:navigate
                                    >{{__('please create some')}}
                                    </a> or <a
                                        href="{{ route('admin.calendar.update', ['season' => $date->season]) }}"
                                        class="inline-block text-blue-600 link"
                                        wire:navigate
                                    >
                                {{__('delete the date')}}</a>
                                {{__('if this is an error or a holiday')}}
                                @else
                                {{__('There are no games yet')}}
                                @endcan
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @script
    <script>
        let echoPublicChannel = window.Echo.channel('live-score');
        let ablyPublicChannelName = echoPublicChannel.name;
        console.log(ablyPublicChannelName);
        $wire.on('refresh-list', () => {
            $wire.$commit();
        });
    </script>
    @endscript
</div>

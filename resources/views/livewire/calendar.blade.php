<div>
    <x-title title="Games schedule" subtitle="Season {{ $cycle }}"/>
    <div class="relative flex flex-col">
        <div class="p-0 sm:p-2 md:p-4">
            <div class="flex flex-wrap">

                @foreach ($dates as $date)

                    <div class="w-full md:w-1/2 lg:w-1/3 px-4" wire:key="date_{{ $date->id }}">
                        <div
                            class="relative grid grid-flow-row auto-rows-max gap-y-2 w-auto py-3 px-6 bg-gray-200 text-gray-900 rounded border border-b-1 border-gray-300 {{ $date->regular ? 'bg-green-500' : 'bg-teal-500' }}">
                            <div class="text-center">
                                @if($hasAccess || $date->checkOpenWindowAccess())
                                    <a
                                        href="{{ route('dates.show', ['date' => $date]) }}"
                                        class="text-white text-lg hover:text-yellow-100 hover:underline" title="click for details"
                                        wire:navigate
                                    >
                                        {{ $date->date->format('jS \o\f M Y') }}
                                    </a>
                                    @if ($date->date->format('ymd') === now()->format('ymd'))
                                        <div class="text-yellow-100 text-lg">
                                            <a href="{{ route('dates.show', ['date' => $date]) }}" class="hover:underline">Live update!</a>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-white text-lg">{{ $date->date->format('jS \o\f M Y') }}</div>
                                @endif
                            </div>
                            @if ($date->title)
                                <div class="text-center text-xl font-medium {{ $date->regular ? 'text-violet-900' : 'text-gray-900' }}">{{ $date->title }}</div>
                            @endif
                            @if ($date->checkOpenWindowAccess())
                                <div class="text-center text-xl text-orange-800" title="click to edit your score">Live scores!</div>
                            @endif
                        </div>

                        @if ($date->events && $date->events()->count() > 0)

                            <table class="w-full mb-4">
                                <thead class="whitespace-nowrap">
                                <tr class="bg-gray-100">
                                    <th class="p-2 text-left text-red-700">Home Team</th>
                                    <th class="p-2 text-right text-blue-700">Visitors</th>
                                </tr>
                                </thead>
                                <tbody class="whitespace-nowrap">
                                @foreach ($date->events as $event)

                                    <tr wire:key="event_{{ $event->id }}">
                                        <td>
                                            <div
                                                class="flex justify-between p-1"
                                                wire:click.self="setMyTeam({{ $event->team_1->id }})"
                                            >
                                                <div class="text-gray-900 text-left {{ $my_team === $event->team_1->id ? 'font-semibold' : '' }}">
                                                    <a href="{{ route('teams.show', ['team' => $event->team_1]) }}" wire:navigate>
                                                        {{ $event->team_1->name }}
                                                    </a>
                                                </div>
                                                @if($event->score1 !== null &&  $event->team_2->name !== 'BYE')
                                                    <div class="mr-1 {{ $event->score1 > 7 ? 'text-green-700 font-semibold' : 'text-red-700' }}">
                                                        {{ $event->score1 }}
                                                    </div>
                                                @else
                                                    <div></div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="flex justify-between"
                                                wire:click.prevent="setMyTeam({{ $event->team_2->id }})"
                                            >
                                                @if($event->score2 !== null &&  $event->team_2->name !== 'BYE')
                                                    <div class="ml-1 {{ $event->score2 > 7 ? 'text-green-700 font-semibold' : 'text-red-700' }}">
                                                        {{ $event->score2 }}
                                                    </div>
                                                @else
                                                    <div></div>
                                                @endif
                                                <div class="text-gray-900 text-right {{ $my_team === $event->team_2->id ? 'font-semibold' : '' }}">
                                                    <a href="{{ route('teams.show', ['team' => $event->team_2]) }}" wire:navigate>
                                                        {{ $event->team_2->name }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @if ($event->team_1->venue_id != $event->venue_id)

                                        <tr>
                                            <td colspan="2" class="text-red-600 text-center font-medium">
                                                Game @ {{ $event->venue->name }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                </tbody>
                            </table>
                        @else
                            <div class="border-b-2 border-x-2 border-green-500 bg-green-100/25 p-2">
                                @can ('create', $date)
                                    There are no games yet, <a href="{{ route('dates.show', ['date' => $date]) }}" wire:navigate>please create
                                        some</a> or <a href="{{ route('admin.calendar.update', ['season' => $date->season]) }}" wire:navigate>delete the date if
                                        this is an error</a>.
                                @else
                                    There are no games yet. The teams will appear when the games are known.
                                @endcan
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

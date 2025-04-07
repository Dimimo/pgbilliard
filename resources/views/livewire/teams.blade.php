<div>
    <x-title title="Participating teams" subtitle="Season {{ $cycle }}" help="teams"/>

    <x-navigation.main-links-buttons/>

    <table class="min-w-full table-auto border-separate border-spacing-y-3">
        <thead class="whitespace-nowrap">
        <tr class="border border-slate-300">
            <th class="border border-slate-300 bg-slate-100 p-2 text-left">
                {{__('Teams')}}
            </th>
            <th class="hidden border border-slate-300 bg-slate-100 p-2 text-left md:table-cell">
                {{__('Venue')}}
            </th>
            <th class="border border-slate-300 bg-slate-100 p-2 text-center" title="number of players">
                <x-svg.list-ul-solid color="fill-blue-700" size="4" padding="mr-2 mb-1"/>
            </th>
            <th class="border border-slate-300 bg-slate-100 p-2 text-left">
                {{__('Captain')}}
            </th>
            <th class="border border-slate-300 bg-slate-100 p-2 text-left">
                {{__('Contact')}}
            </th>
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach ($teams as $team)
            <tr wire:key="team_{{ $team->id }}" @class(['bg-green-50' => $my_team === $team->id])>
                <td class="border-b-2 border-slate-300 p-2">
                    <div class="flex justify-start">
                        @can ('update', $team)
                            <div class="mr-2">
                                <a href="{{ route('teams.edit', ['team' => $team]) }}" wire:navigate>
                                    <x-svg.pen-to-square-solid color="fill-blue-500" size="5" padding="mb-1"/>
                                </a>
                            </div>
                        @endcan
                        <div class="font-semibold">
                            <a
                                href="{{ route('teams.show', ['team' => $team]) }}"
                                class="link"
                                wire:navigate
                            >
                                {{ $team->name }}
                            </a>
                        </div>
                    </div>
                </td>
                <td class="hidden border-b-2 border-slate-300 p-2 md:table-cell">
                    <div class="flex justify-start">
                        <div class="mr-2">
                            @can ('update', $team->venue)
                                <a href="{{ route('venues.edit', ['venue' => $team->venue]) }}" wire:navigate>
                                    <x-svg.pen-to-square-solid color="fill-blue-500" size="5" padding="mb-1"/>
                                </a>
                            @endcan
                        </div>
                        <div>
                            <a
                                href="{{ route('venues.show', ['venue' => $team->venue]) }}"
                                class="link"
                                wire:navigate
                            >
                                {{ $team->venue->name }}
                            </a>
                        </div>
                    </div>
                </td>
                <td class="border-b-2 border-slate-300 p-2 text-center">
                    <a
                        href="{{ route('teams.show', ['team' => $team]) }}"
                        class="rounded-full border border-indigo-400 bg-indigo-50 px-2 py-1 text-blue-800 hover:border-blue-700 hover:bg-blue-100 hover:text-blue-600"
                        wire:navigate
                    >
                        {{ $team->players()->whereActive(true)->count() }}
                    </a>
                </td>
                <td class="border-b-2 border-slate-300 p-2">
                    <div class="flex justify-start">
                        <div>
                            <a
                                href="{{ route('teams.show', ['team' => $team]) }}"
                                class="link"
                                wire:navigate
                            >
                                {{ $team->captain() ? $team->captain()->name : '(unknown)' }}
                            </a>
                        </div>
                    </div>
                </td>
                <td class="border-b-2 border-slate-300 p-2 text-left">
                    @auth()
                        {{ $team->captain()?->contact_nr ?: $team->venue->contact_nr }}
                    @else
                        hidden
                    @endauth
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

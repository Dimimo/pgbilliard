<div>
    <x-title title="Participating teams" subtitle="Season {{ $cycle }}"/>
    <table class="min-w-full table-auto border-separate border-spacing-y-3">
        <thead class="whitespace-nowrap">
        <tr class="border border-slate-300">
            <th class="p-2 text-left border border-slate-300 bg-slate-100">Teams</th>
            <th class="p-2 text-left border border-slate-300 bg-slate-100">Venue</th>
            <th class="p-2 text-center border border-slate-300 bg-slate-100">
                <img class="mx-auto" src="{{ secure_asset('svg/ordered-list.svg') }}" alt="Number of Players" width="24" height="24">
            </th>
            <th class="p-2 text-left border border-slate-300 bg-slate-100">Captain</th>
            <th class="p-2 text-left border border-slate-300 bg-slate-100">Contact</th>
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach ($teams as $team)
            <tr wire:key="team_{{ $team->id }}">
                <td class="p-2 border-b-2 border-slate-300">
                    <div class="flex justify-start">
                        @can ('update', $team)
                            <div class="mr-2">
                                <a href="/teams/edit/{{ $team->id }}" wire:navigate>
                                    <img class="mx-auto" src="{{ secure_asset('svg/pen-square.svg') }}" alt="Edit this team" width="24" height="24">
                                </a>
                            </div>
                        @endcan
                        @can('delete', $team)
                            @if($team->hasGames() === false)
                                <div class="mr-4">
                                    <img class="mx-auto" src="{{ secure_asset('svg/delete-item.svg') }}" alt="Delete this team" width="20" height="20">
                                </div>
                            @endif
                        @endcan
                        <div class="font-semibold">
                            <a href="/teams/show/{{ $team->id }}" wire:navigate>
                                {{ $team->name }}
                            </a>
                        </div>
                    </div>
                </td>
                <td class="p-2 border-b-2 border-slate-300">
                    <div class="flex justify-start">
                        <div class="mr-2">
                            @can ('update', $team->venue)
                                <a href="/venues/edit/{{ $team->venue->id }}" wire:navigate>
                                    <img class="mx-auto" src="{{ secure_asset('svg/pen-square.svg') }}" alt="Edit this team" width="24" height="24">
                                </a>
                            @endcan
                        </div>
                        <div>
                            <a href="/venues/show/{{ $team->venue->id }}" wire:navigate>
                                {{ $team->venue->name }}
                            </a>
                        </div>
                    </div>
                </td>
                <td class="p-2 border-b-2 border-slate-300 text-center">{{ $team->players()->count() }}</td>
                <td class="p-2 border-b-2 border-slate-300">
                    <div class="flex justify-start">
                        <div class="mr-2">
                            @can ('update', $team)
                                <a href="/teams/edit/{{ $team->id }}" wire:navigate>
                                    <img class="mx-auto" src="{{ secure_asset('svg/pen-square.svg') }}" alt="Edit this team" width="24" height="24">
                                </a>
                            @endcan
                        </div>
                        <div>
                            {{ $team->captain() ? $team->captain()->name : '(unknown)' }}
                        </div>
                    </div>
                </td>
                <td class="p-2 border-b-2 border-slate-300 text-left">{{ $team->captain()?->contact_nr ?: $team->venue->contact_nr }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

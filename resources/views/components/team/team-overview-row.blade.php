@props(['team', 'my_team'])
<tr
    wire:key="team_{{ $team->id }}"
    @class(['bg-green-50' => $my_team === $team->id])
>
    <td class="border-b-2 border-slate-300 p-2">
        <div class="flex justify-start">
            @can('update', $team)
                <div class="mr-2">
                    <a
                        href="{{ route('teams.edit', ['team' => $team]) }}"
                        wire:navigate
                    >
                        <x-svg.pen-to-square-solid
                            color="fill-blue-500"
                            size="5"
                            padding="mb-1"
                        />
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
                @can('update', $team->venue)
                    <a
                        href="{{ route('venues.edit', ['venue' => $team->venue]) }}"
                        wire:navigate
                    >
                        <x-svg.pen-to-square-solid
                            color="fill-blue-500"
                            size="5"
                            padding="mb-1"
                        />
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
            {{ $team->activePlayers()->count() }}
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
                    {{ $team->captain_name }}
                </a>
            </div>
        </div>
    </td>
    <td class="border-b-2 border-slate-300 p-2 text-left">
        {{ $team->contact_nr }}
    </td>
</tr>

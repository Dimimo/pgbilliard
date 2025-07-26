@props(['team', 'player', 'rank'])

<div class="rounded-lg bg-indigo-50 p-4">
    @if ($team)
        <div class="mb-4 text-lg">{{__('Your participation')}}:</div>
        <div class="mb-4">
            <div>
                {{__('You play for')}} <a
                    href="{{ route('teams.show', ['team' => $team]) }}"
                    class="inline-block text-blue-800 link"
                    wire:navigate
                >
                    {{ $team->name }}
                </a>
            </div>
            <div class="my-4">
                {{__('Your current')}} <a
                    href="{{ route('rank') }}"
                    class="inline-block text-blue-800 link"
                    wire:navigate
                >{{__('individual rank is')}}</a>
                <span class="m-1 rounded-full border border-green-500 bg-green-100 px-2 py-1 font-bold">
                            {{ $rank }}
                        </span>
            </div>
            @if ($player->captain)
                <div>
                    {{__('You are the Captain, you can')}} <a
                        href="{{ route('teams.edit', ['team' => $team]) }}"
                        class="inline-block text-blue-800 link"
                        wire:navigate
                    >
                        {{__('manage your team here')}}
                    </a>
                </div>
            @endif
        </div>
        <div class="text-lg">{{__('Your team members are')}}:</div>
        <ul class="list-inside list-disc">
            @foreach($team->players->where('active', true)->sortBy('name')->sortByDesc('captain') as $member)
                <li>{{ $member->user->name }} {{ $member->captain ? 'is captain' : '' }}</li>
            @endforeach
        </ul>

    @else
        <div class="mb-4">
            {{__("You don't play for a team. If you think this is an error")}}
            <a href="{{ route('teams.index') }}" class="inline-block text-blue-800 link" wire:navigate>
                {{__('contact your captain or bar owner')}}
            </a>
        </div>
    @endif
</div>

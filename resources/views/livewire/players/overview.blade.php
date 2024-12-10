<div class="mt-4">
    @forelse ($players as $player)
        <div class="flex justify-center" wire:key="{{ $player->id }}">
            <div class="p-2">
                <x-team.captain :player="$player"/>
            </div>
            <div class="p-2 text-xl">{{ $player->name }}</div>
            <div class="p-2 text-xl">{{ $player->contact_nr }}</div>
        </div>
    @empty
        <div class="flex justify-center text-xl">No known selected players in this team</div>
    @endforelse

    @if(!request()->is('teams/show/*'))
        <a href="{{ route('teams.show', ['team' => $team]) }}" class="flex justify-end px-4 pt-4" wire:navigate>
            <div class="text-blue-700">
                Team details
            </div>
        </a>
    @endif

    @can ('update', $team)
        <a href="{{ route('teams.edit', ['team' => $team]) }}" class="flex justify-end px-4" wire:navigate>
            <div class="mr-2">
                <img src="{{ secure_asset('svg/pen-square.svg') }}" alt="" width="24" height="24">
            </div>
            <div class="text-blue-700">
                Edit the team players
            </div>
        </a>
    @endcan

</div>

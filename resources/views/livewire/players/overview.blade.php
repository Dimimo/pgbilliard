<div class="mt-4">
    @forelse ($players as $player)
        <div class="flex justify-center" wire:key="{{ $player->id }}">
            <div class="p-2">
                <x-captain :player="$player"/>
            </div>
            <div class="p-2 text-xl">{{ $player->name }}</div>
            <div class="p-2 text-xl">{{ $player->contact_nr }}</div>
        </div>
    @empty
        <div class="flex justify-center text-xl">No known selected players in this team</div>
    @endforelse

    @if(!request()->is('teams/show/*'))
            <a class="flex justify-end px-4 pt-4" href="/teams/show/{{  $team->id }}" wire:navigate>
                <div class="text-blue-700">
                    Team details
                </div>
            </a>
    @endif

    @can ('update', $team)
        <a class="flex justify-end px-4" href="/teams/edit/{{  $team->id }}" wire:navigate>
            <div class="mr-2">
                <img src="{{ secure_asset('svg/pen-square.svg') }}" alt="" width="24" height="24">
            </div>
            <div class="text-blue-700">
                Edit the team players
            </div>
        </a>
    @endcan

</div>

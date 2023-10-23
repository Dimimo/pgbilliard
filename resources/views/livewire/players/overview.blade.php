<div class="mt-4">
    @forelse ($players as $player)
        <div class="flex justify-center gap-4" wire:key="{{ $player->id }}">
            <div>
                <x-captain :player="$player"/>
            </div>
            <div class="text-xl">{{ $player->name }}</div>
            <div class="text-xl">{{ $player->contact_nr }}</div>
        </div>
    @empty
        <div class="flex justify-center text-xl">No known selected players in this team</div>
    @endforelse
    @can ('update', $team)
        <a class="flex justify-end p-4" href="/admin/teams/edit/{{  $team->id }}" wire:navigate>
            <div class="mr-2">
                <img src="{{ secure_asset('svg/pen-square.svg') }}" alt="" width="24" height="24">
            </div>
            <div class="text-blue-700">
                Edit the team players
            </div>
        </a>
    @endif
</div>

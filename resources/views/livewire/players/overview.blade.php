<div class="mt-4">
    @foreach ($players as $player)
        <div class="flex justify-center gap-4" wire:key="{{ $player->id }}">
            <div>
                <x-captain :player="$player"/>
            </div>
            <div class="text-xl">{{ $player->name }}</div>
            <div class="text-xl">{{ $player->contact_nr }}</div>
        </div>
    @endforeach
    @if ($hasAccess)
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

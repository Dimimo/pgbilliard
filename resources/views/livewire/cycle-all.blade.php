<div class="flex flex-col space-y-2 text-center">
    @foreach($seasons as $season)
        <div class="cursor-pointer font-bold text-blue-800 hover:bg-blue-50 hover:text-blue-600 hover:underline"
             wire:click="selectedSeason({{ $season->id }})"
        >
            {{ $season->cycle }}
            <span class="text-sm text-gray-600">
                ({{ $season->dates_count }} games, {{ $season->teams_count }} teams)
            </span>
        </div>
    @endforeach
</div>

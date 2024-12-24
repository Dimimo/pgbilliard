<div>
    <article class="my-4 flex flex-col rounded-lg border border-gray-700 bg-green-100 p-4 space-y-2">
        <p>
            A day schedule it the <span class="font-bold">blueprint</span> for the daily billiard schedule. I noticed some people like
            the 'old' schedule and some the 'new'. They will be able to choose.
        </p>
        <p>
            Whatever schedule the captains choose, they can still move around the players as they agree upon. Again: these proposed
            schedules are only a blueprint to fill in the players.
        </p>
        <p>
            Of course, a schedule is independent of Seasons, Venues and playing dates.
        </p>
    </article>

    @forelse($formats as $format)
        <div class="mb-4 text-lg">Existing formats:</div>
        <div class="flex flex-col space-y-2">
            <a
                href="{{ route('admin.schedule.update', ['format' => $format->id]) }}"
                class="w-min whitespace-nowrap text-lg border border-transparent font-semibold text-blue-700 hover:border hover:border-blue-700 hover:bg-blue-100 px-2"
                wire:navigate
            >
                <x-svg.circle-info-solid color="fill-blue-600" size="5" padding="mr-2 mb-1"/> {{ $format->name }}
            </a>
            <div class="text-sm">{{ $format->details }}</div>
        </div>
    @empty
        <div>No Day schedules exist yet.</div>
    @endforelse
    <div class="my-8">
        <x-svg.square-plus-solid color="fill-green-700" size="5"/>
        <a
            href="{{ route('admin.schedule.create') }}"
            class="border border-transparent font-semibold text-blue-700 hover:border hover:border-blue-700 hover:bg-blue-100"
            wire:navigate
        >
            Create a new Schedule.
        </a>
    </div>
</div>

<div>
    <article class="flex flex-col space-y-2 my-4 rounded-lg border border-gray-700 bg-green-100 p-4">
        <p>
            A day schedule it the <span class="font-bold">blueprint</span> for the daily billiard schedule. I noticed some people like
            the 'old' schedule and some the 'new'. They will be able to chose.
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
        <div>
            <a
                href="{{ route('admin.schedule.update', ['format' => $format->id]) }}"
                class="border border-transparent font-semibold text-blue-700 hover:border hover:border-blue-700 hover:bg-blue-100"
                wire:navigate
            >
                {{ $format->name }}
            </a>
        </div>
    @empty
        <div>No Day schedules exist yet.
        </div>
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

<div>
    <article
        class="my-4 flex flex-col space-y-2 rounded-lg border border-gray-700 bg-green-100 p-4"
    >
        <p>
            A day schedule it the
            <span class="font-bold">blueprint</span>
            for the daily billiard schedule. I noticed some people like the 'old' schedule and some
            the 'new'. They will be able to choose.
        </p>
        <p>
            Whatever schedule the captains choose, they can still move around the players as they
            agree upon. Again: these proposed schedules are only a blueprint to fill in the players.
        </p>
        <p>Of course, a schedule is independent of Seasons, Venues and playing dates.</p>
    </article>

    @forelse ($formats as $format)
        <div class="mb-4 text-lg">Existing formats:</div>
        <div class="flex flex-col space-y-2">
            <a
                href="{{ route('admin.schedule.update', ['format' => $format->id]) }}"
                class="w-min whitespace-nowrap border border-transparent px-2 text-lg font-semibold text-blue-700 hover:border hover:border-blue-700 hover:bg-blue-100"
                wire:navigate
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    class="mb-1 mr-2 inline-block h-5 w-5 fill-blue-600"
                >
                    <path
                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"
                    />
                </svg>
                {{ $format->name }}
            </a>
            <div class="text-sm">{{ $format->details }}</div>
        </div>
    @empty
        <div>No Day schedules exist yet.</div>
    @endforelse
    <div class="my-8">
        <x-svg.square-plus-solid color="fill-green-700" size="5" />
        <a
            href="{{ route('admin.schedule.create') }}"
            class="border border-transparent font-semibold text-blue-700 hover:border hover:border-blue-700 hover:bg-blue-100"
            wire:navigate
        >
            Create a new Schedule.
        </a>
    </div>
</div>

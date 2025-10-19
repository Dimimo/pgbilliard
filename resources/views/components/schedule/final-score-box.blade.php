@props(['event'])

<div
    @class(['px-2 pb-3' => $event->confirmed
    || $event->score1 + $event->score2 === 15
    || ($event->date->regular && ($event->score1 === 8 || $event->score2 === 8))
    ])
>
    <div
        @class(['inline-block', 'text-2xl text-green-700' => $event->score1 > 7, 'text-xl text-gray-600' => $event->score1 <= 7])
    >
        {{ $event->team_1->name }}
    </div>

    <div @class(['mx-2 inline-block', 'rounded-lg bg-green-100 px-2' => $event->confirmed])>
        <div
            @class(['inline-block', 'text-2xl text-green-700' => $event->score1 > 7, 'text-xl text-gray-600' => $event->score1 <= 7])
        >
            {{ $event->score1 }}
        </div>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 448 512"
            class="mx-2 mb-2 inline-block h-3 w-3 fill-gray-600"
        >
            <path
                d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"
            />
        </svg>
        <div
            @class(['inline-block', '', 'text-2xl text-green-700' => $event->score2 > 7, 'text-xl text-gray-600' => $event->score2 <= 7])
        >
            {{ $event->score2 }}
        </div>
    </div>

    <div
        @class(['inline-block', 'text-2xl text-green-700' => $event->score2 > 7, 'text-xl text-gray-600' => $event->score2 <= 7])
    >
        {{ $event->team_2->name }}
    </div>
</div>

<div class="mt-12 rounded-lg border-2 border-gray-900 p-4">
    <x-title
        title="{{__('The individual ranking overview')}}"
        subtitle="{{__('Season')}} {{ session('cycle') }}"
        help="ranking"
        :gradient="false"
    />

    <div class="m-auto mb-4 rounded-lg border border-indigo-400 bg-indigo-50 p-2 text-center">
        <div class="mb-4 font-bold">
            This is still experimental! Please read the help file
            <button wire:click="$dispatch('openModal', { component: 'help.ranking' })">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    class="mb-1 inline-block h-4 w-4 fill-green-700"
                >
                    <path
                        d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm169.8-90.7c7.9-22.3 29.1-37.3 52.8-37.3l58.3 0c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24l0-13.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1l-58.3 0c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"
                    />
                </svg>
            </button>
        </div>
        <div class="mb-4">Some things to consider.</div>
        <div class="mb-4">
            At first the list shows
            <span class="font-bold">the {{ $median }} best players</span>
            of a total of {{ $results->count() }} players in this Season.
        </div>
        <div class="mb-4">
            How and why?
            <br />
            The number is the median of the total games played (
            <span class="text-lg font-bold text-blue-700">#</span>
            in the list)
        </div>
        <div class="mb-4">
            Optionally, you can see the list of all players.
            <br />
            Either way, the calculation of the percentage as following:
            <br />
            <span class="font-mono">
                (Games Won / Total Games) * (Days Participated / Max Playing Days) * 100
            </span>
        </div>
        <div class="mb-4">
            {{ __('New') }}: {{ __('click on a name to see the game details') }}
        </div>
        @if (session('is_admin'))
            <div class="text-center">
                <button
                    type="button"
                    class="rounded-lg border border-gray-600 bg-gray-50 px-4 py-2 text-gray-700"
                    wire:click="requestUpdate"
                >
                    Request update
                    <span class="italic">(only for admins)</span>
                </button>
                <x-forms.action-message on="updated">{{ __('Updated') }}!</x-forms.action-message>
            </div>
        @endif
    </div>

    <div class="flex justify-center">
        <x-forms.primary-button wire:click="toggleMedian">
            @if ($show_all_results)
                Show only the {{ $median }} most active players
            @else
                    Show the list of ALL players
            @endif
        </x-forms.primary-button>
    </div>

    <table class="table-collapse my-2 min-w-full bg-transparent md:my-4">
        <thead class="whitespace-nowrap">
            <tr>
                <th class="bg-gray-300 p-2 text-center text-gray-900">
                    <!-- svg.list-ol-solid -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        class="mb-1 inline-block h-5 w-5 fill-gray-900"
                    >
                        <path
                            d="M24 56c0-13.3 10.7-24 24-24l32 0c13.3 0 24 10.7 24 24l0 120 16 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l16 0 0-96-8 0C34.7 80 24 69.3 24 56zM86.7 341.2c-6.5-7.4-18.3-6.9-24 1.2L51.5 357.9c-7.7 10.8-22.7 13.3-33.5 5.6s-13.3-22.7-5.6-33.5l11.1-15.6c23.7-33.2 72.3-35.6 99.2-4.9c21.3 24.4 20.8 60.9-1.1 84.7L86.8 432l33.2 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-88 0c-9.5 0-18.2-5.6-22-14.4s-2.1-18.9 4.3-25.9l72-78c5.3-5.8 5.4-14.6 .3-20.5zM224 64l256 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-256 0c-17.7 0-32-14.3-32-32s14.3-32 32-32zm0 160l256 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-256 0c-17.7 0-32-14.3-32-32s14.3-32 32-32zm0 160l256 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-256 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"
                        />
                    </svg>
                </th>
                <th class="bg-indigo-100 text-center">
                    <!-- svg.percent-solid -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 384 512"
                        class="mb-1 inline-block h-5 w-5 fill-indigo-500"
                    >
                        <path
                            d="M374.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-320 320c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l320-320zM128 128A64 64 0 1 0 0 128a64 64 0 1 0 128 0zM384 384a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"
                        />
                    </svg>
                </th>
                <th class="bg-blue-300 p-2 text-left text-gray-900">{{ __('Name') }}</th>
                <th class="bg-gray-100 p-2 text-left" title="{{ __('Current team') }}">
                    {{ __('Current Team') }}
                </th>
                <th class="bg-green-300 p-2 text-center">
                    <!-- svg.thumbs-up-solid -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        class="mb-1 inline-block h-5 w-5 fill-green-600"
                    >
                        <path
                            d="M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2l144 0c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48l-97.5 0c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3l0-38.3 0-48 0-24.9c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192l64 0c17.7 0 32 14.3 32 32l0 224c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32L0 224c0-17.7 14.3-32 32-32z"
                        />
                    </svg>
                </th>
                <th class="bg-red-200 p-2 text-center">
                    <!-- svg.thumbs-down-solid -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        class="mb-1 inline-block h-5 w-5 fill-red-600"
                    >
                        <path
                            d="M313.4 479.1c26-5.2 42.9-30.5 37.7-56.5l-2.3-11.4c-5.3-26.7-15.1-52.1-28.8-75.2l144 0c26.5 0 48-21.5 48-48c0-18.5-10.5-34.6-25.9-42.6C497 236.6 504 223.1 504 208c0-23.4-16.8-42.9-38.9-47.1c4.4-7.3 6.9-15.8 6.9-24.9c0-21.3-13.9-39.4-33.1-45.6c.7-3.3 1.1-6.8 1.1-10.4c0-26.5-21.5-48-48-48l-97.5 0c-19 0-37.5 5.6-53.3 16.1L202.7 73.8C176 91.6 160 121.6 160 153.7l0 38.3 0 48 0 24.9c0 29.2 13.3 56.7 36 75l7.4 5.9c26.5 21.2 44.6 51 51.2 84.2l2.3 11.4c5.2 26 30.5 42.9 56.5 37.7zM32 384l64 0c17.7 0 32-14.3 32-32l0-224c0-17.7-14.3-32-32-32L32 96C14.3 96 0 110.3 0 128L0 352c0 17.7 14.3 32 32 32z"
                        />
                    </svg>
                </th>
                <th
                    class="bg-blue-100 p-2 text-center"
                    title="{{ __('Number of games participated') }}"
                >
                    <!-- svg.hashtag-solid -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512"
                        class="mb-1 inline-block h-5 w-5 fill-blue-700"
                    >
                        <path
                            d="M181.3 32.4c17.4 2.9 29.2 19.4 26.3 36.8L197.8 128l95.1 0 11.5-69.3c2.9-17.4 19.4-29.2 36.8-26.3s29.2 19.4 26.3 36.8L357.8 128l58.2 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-68.9 0L325.8 320l58.2 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-68.9 0-11.5 69.3c-2.9 17.4-19.4 29.2-36.8 26.3s-29.2-19.4-26.3-36.8l9.8-58.7-95.1 0-11.5 69.3c-2.9 17.4-19.4 29.2-36.8 26.3s-29.2-19.4-26.3-36.8L90.2 384 32 384c-17.7 0-32-14.3-32-32s14.3-32 32-32l68.9 0 21.3-128L64 192c-17.7 0-32-14.3-32-32s14.3-32 32-32l68.9 0 11.5-69.3c2.9-17.4 19.4-29.2 36.8-26.3zM187.1 192L165.8 320l95.1 0 21.3-128-95.1 0z"
                        />
                    </svg>
                </th>
                <th
                    class="bg-green-100 p-2 text-center"
                    title="{{ __('Number of participated playing dates') }}"
                >
                    <!-- svg.calendar-days-solid -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 448 512"
                        class="mb-1 inline-block h-5 w-5 fill-green-700"
                    >
                        <path
                            d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm64 80l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 400l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z"
                        />
                    </svg>
                </th>
            </tr>
        </thead>
        <tbody class="whitespace-nowrap">
            @foreach ($results->sortByDesc('played')->take($count)->sortByDesc('percentage') as $result)
                <tr class="h-8" wire:key="rank-{{ $result->player->id }}">
                    <td
                        class="bg-gray-200 p-2 text-center text-gray-900"
                        title="{{ __('Your current position') }}"
                    >
                        <span class="font-bold">{{ $rank++ }}</span>
                    </td>
                    <td class="bg-indigo-50 text-center">{{ $result->percentage }}%</td>
                    <td class="bg-blue-100 p-2 text-left font-bold">
                        <a
                            class="link"
                            href="{{ route('players.show', ['player' => $result->player->id]) }}"
                            wire:navigate
                        >
                            {{ $result->user->name }}
                        </a>
                    </td>
                    <td class="bg-gray-50 p-2 text-left">{{ $result->player->team->name }}</td>
                    <td class="bg-green-100 text-center">{{ $result->won }}</td>
                    <td class="bg-red-100 text-center">{{ $result->lost }}</td>
                    <td class="bg-blue-50 text-center">{{ $result->played }}</td>
                    <td class="bg-green-50 text-center">{{ $result->participated }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @script
        <script>
            $wire.on('refresh-request', () => {
                $wire.$commit();
            });
        </script>
    @endscript
</div>

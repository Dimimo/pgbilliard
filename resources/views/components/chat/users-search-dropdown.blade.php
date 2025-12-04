@props(['room', 'list_users'])

<div
    class="relative w-max font-[sans-serif]"
    x-data="{ open: false }"
    @click.outside="open = false"
    @close.stop="open = false"
>
    <button
        type="button"
        @click="open = ! open"
        class="rounded border-none bg-blue-600 px-6 py-2 text-sm font-semibold text-white outline-none hover:bg-blue-700 active:bg-blue-600"
    >
        {{ __('Invite players') }}

        <svg
            x-show="! open"
            xmlns="http://www.w3.org/2000/svg"
            class="ml-3 inline w-3 fill-white"
            viewBox="0 0 448 512"
        >
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                data-original="#000000"
                d="M201.4 374.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 306.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"
            />
        </svg>
        <svg
            x-show="open"
            xmlns="http://www.w3.org/2000/svg"
            class="ml-3 inline w-3 fill-white"
            viewBox="0 0 448 512"
        >
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                data-original="#000000"
                d="M201.4 137.4c12.5-12.5 32.8-12.5 45.3 0l160 160c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 205.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160z"
            />
        </svg>
    </button>
    <div class="mb-2">
        <label>
            <input
                placeholder="Search for..."
                class="w-full rounded border-none bg-gray-50 px-4 py-2.5 text-sm font-semibold text-gray-500 outline-blue-600"
                wire:model.live.debounce="search"
                @click="open = true"
            />
        </label>
    </div>
    <ul
        class="absolute z-1000 max-h-96 w-max min-w-full overflow-auto rounded bg-white px-2 py-2 shadow-lg"
        x-show="open"
    >
        <x-chat.user-search-item :room="$room" :users="$list_users" />
    </ul>
</div>

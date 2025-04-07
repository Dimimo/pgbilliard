@props(['room', 'list_users'])

<div class="relative font-[sans-serif] w-max" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <button type="button"
            @click="open = ! open"
            class="px-6 py-2 rounded text-white text-sm font-semibold border-none outline-none bg-blue-600 hover:bg-blue-700 active:bg-blue-600"
    >
        {{__('Invite players')}}

        <svg
            x-show="! open"
            xmlns="http://www.w3.org/2000/svg"
            class="w-3 fill-white inline ml-3"
            viewBox="0 0 448 512"
        >
            <path
                fill-rule="evenodd"
                clip-rule="evenodd" data-original="#000000"
                d="M201.4 374.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 306.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"
            />
        </svg>
        <svg
            x-show="open"
            xmlns="http://www.w3.org/2000/svg"
            class="w-3 fill-white inline ml-3"
            viewBox="0 0 448 512"
        >
            <path
                fill-rule="evenodd"
                clip-rule="evenodd" data-original="#000000"
                d="M201.4 137.4c12.5-12.5 32.8-12.5 45.3 0l160 160c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L224 205.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l160-160z"
            />
        </svg>
    </button>
    <div class="mb-2">
        <label>
            <input
                placeholder="Search for..."
                class="px-4 py-2.5 w-full rounded text-gray-500 text-sm font-semibold border-none outline-blue-600 bg-gray-50"
                wire:model.live.debounce="search"
                @click="open = true"
            />
        </label>
    </div>
    <ul
        class='absolute shadow-lg bg-white py-2 px-2 z-[1000] min-w-full w-max rounded max-h-96 overflow-auto'
        x-show="open"
    >
        <x-chat.user-search-item :room="$room" :users="$list_users"/>
    </ul>
</div>

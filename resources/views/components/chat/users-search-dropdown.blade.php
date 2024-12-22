@props(['room', 'list_users'])

<div>
    <div class="relative font-[sans-serif] w-max">
        <button type="button"
                class="px-6 py-2 rounded text-white text-sm font-semibold border-none outline-none bg-blue-600 hover:bg-blue-700 active:bg-blue-600">
            Invite people
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 fill-white inline ml-3" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                      d="M11.99997 18.1669a2.38 2.38 0 0 1-1.68266-.69733l-9.52-9.52a2.38 2.38 0 1 1 3.36532-3.36532l7.83734 7.83734 7.83734-7.83734a2.38 2.38 0 1 1 3.36532 3.36532l-9.52 9.52a2.38 2.38 0 0 1-1.68266.69734z"
                      clip-rule="evenodd" data-original="#000000"/>
            </svg>
        </button>
        <div class="mb-2">
            <label>
                <input
                    placeholder="Search for..."
                    class="px-4 py-2.5 w-full rounded text-gray-500 text-sm font-semibold border-none outline-blue-600 bg-gray-50"
                    wire:model.live.debounce="search"
                />
            </label>
        </div>
        <ul class='absolute shadow-lg bg-white py-2 px-2 z-[1000] min-w-full w-max rounded max-h-96 overflow-auto'>
            <x-chat.user-search-item :room="$room" :users="$list_users"/>
        </ul>
    </div>
</div>

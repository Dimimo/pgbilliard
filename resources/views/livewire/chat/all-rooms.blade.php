<div class="p-2 md:p-4 bg-gray-100 rounded-lg shadow-lg">
    <h2 class="text-xl font-semibold m-4 mt-4 pl-4">Public Chat</h2>
    @forelse($public_rooms as $public_room)
        <div>
            <a
                class="text-blue-800 hover:text-blue-600 hover:underline"
                href="{{ route('chat.room', ['chatRoom' => $public_room]) }}"
                wire:navigate
            >
                {{ $public_room->name }}
            </a>
        </div>
    @empty
        <div>No other public rooms</div>
    @endforelse

    <h2 class="text-xl font-semibold m-4 mt-4 pl-4">Private Chat</h2>
    @forelse($private_rooms as $private_room)
        <div>
            <a
                class="text-blue-800 hover:text-blue-600 hover:underline"
                href="{{ route('chat.room', ['chatRoom' => $private_room]) }}"
                wire:navigate
            >
                {{ $private_room->name }}
            </a> ({{ $private_room->users_count }} invited)
        </div>
    @empty
        <div>No private rooms</div>
    @endforelse
    <div class="my-4 text-xl text-blue-700 hover:text-[#007bff]">
        <a
            class="text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('chat.room.create') }}"
            wire:navigate
        >
            <x-svg.square-plus-solid color="fill-green-600" size="5"/>
            Create a chat room
        </a>
    </div>
</div>

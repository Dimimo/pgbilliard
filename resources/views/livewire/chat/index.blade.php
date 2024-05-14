<div class="mx-auto mt-4">
    <div class="bg-gray-100/25">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/3 px-4">
                <div class="p-2 md:p-4 bg-gray-100 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold m-4 mt-4 pl-4">Public Chat Rooms</h2>
                    @forelse($public_rooms as $public_room)
                        <div>
                            <a href="{{ route('chat.room', ['chatRoom' => $public_room]) }}" wire:navigate>
                                {{ $public_room->name }}
                            </a>
                        </div>
                    @empty
                        <div>No chat rooms available</div>
                    @endforelse

                    <h2 class="text-xl font-semibold m-4 mt-4 pl-4">Private Chat Rooms</h2>
                    @forelse($private_rooms as $private_room)
                        <div>
                            <a href="{{ route('chat.room', ['chatRoom' => $private_room]) }}" wire:navigate>
                                {{ $private_room->name }}
                            </a> ({{ $private_room->users_count }} invited)
                        </div>
                    @empty
                        <div>No chat rooms available</div>
                    @endforelse
                    <div class="my-4 text-xl text-blue-700 hover:text-[#007bff]">
                        <a href="{{ route('chat.room.create') }}" wire:navigate>Create a chat room</a>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-2/3 px-4">
                <livewire:chat.messages :room="$chatRoom"/>
            </div>
        </div>
    </div>
</div>

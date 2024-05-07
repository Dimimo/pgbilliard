<div class="mx-auto mt-4">
    <div class="bg-gray-100/25">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/3 px-4">
                <div class="p-2 md:p-4 bg-gray-100 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold m-4 mt-4 pl-4">Managed by {{ $room->owner->name }}</h2>
                    <h3 class="m-4">Participating Players</h3>
                    @forelse($room->users->sortBy('name') as $user)
                        <div>{{ $user->name }}</div>
                    @empty
                        <div>Nobody yet</div>
                    @endforelse
                </div>
            </div>

            <div class="w-full lg:w-2/3 px-4">
                <x-chat.messages :messages="$room->messages"/>
            </div>
        </div>
    </div>
</div>

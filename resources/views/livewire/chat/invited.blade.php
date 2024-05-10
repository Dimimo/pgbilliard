<div class="p-2 md:p-4 mb-4 bg-gray-100 rounded-lg shadow-lg">
    <h2 class="text-xl font-semibold m-4 mt-4 pl-4">Managed by {{ $room->owner->name }}</h2>
    <h3 class="m-4">Participating Players</h3>
    @forelse($room->users->sortBy('name') as $user)
        <div class="flex justify-between p-1" wire:key="{{ $user->id }}">
            <div>{{ $user->name }}</div>
            @can('update', $room)
                <div class="inline-block align-middle px-2 cursor-pointer">
                    <img
                        src="{{ secure_asset('svg/user-delete.svg') }}"
                        alt=""
                        width="20"
                        height="20"
                        wire:click="toggleUser({{ $user->id }})"
                        wire:loading.remove
                        wire:target="toggleUser({{ $user->id }})"
                    >
                </div>
                <div wire:loading wire:target="toggleUser({{ $user->id }})">
                    <x-spinner/>
                </div>
            @endcan
        </div>
    @empty
        <div>Nobody yet</div>
    @endforelse
</div>

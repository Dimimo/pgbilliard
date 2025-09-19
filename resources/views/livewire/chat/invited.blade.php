<div class="mb-4 rounded-lg bg-gray-100 p-2 shadow-lg md:p-4">
    <h2 class="m-4 mt-4 pl-4 text-xl font-semibold">
        {{ __('Managed by') }} {{ $room->owner->name }}
    </h2>
    <h3 class="m-4">{{ __('Participating Players') }}</h3>
    @forelse ($room->users->sortBy('name') as $user)
        <div class="flex justify-between p-1" wire:key="{{ $user->id }}">
            <div>{{ $user->name }}</div>
            @can('update', $room)
                <button
                    class="inline-block cursor-pointer px-2 align-middle"
                    wire:click="toggleUser({{ $user->id }})"
                    wire:confirm="{{ __('Remove this user from the chat? All related messages will be deleted too') }}."
                    wire:loading.remove
                    wire:target="toggleUser({{ $user->id }})"
                >
                    <x-svg.user-minus-solid color="fill-red-500" size="5" padding="mb-1" />
                </button>
                <div wire:loading wire:target="toggleUser({{ $user->id }})">
                    <x-forms.spinner />
                </div>
            @endcan
        </div>
    @empty
        <div>{{ __('Nobody yet') }}</div>
    @endforelse
</div>

<div class="mx-auto mt-4">
    <div class="bg-gray-100/25">
        <div class="flex flex-wrap">
            <div class="w-full lg:w-1/3 px-4">
                <livewire:chat.invited lazy :room="$room"/>
                @if ($room->private)
                    <livewire:chat.user-select lazy :room="$room"/>
                @endif
            </div>

            <div class="w-full lg:w-2/3 px-4">
                <x-chat.messages :messages="$room->messages"/>
            </div>
        </div>
    </div>
</div>

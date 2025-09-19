<div class="mx-auto mt-4">
    <div class="bg-gray-100/25">
        <div class="flex flex-wrap">
            <div class="w-full px-4 lg:w-1/3">
                <livewire:chat.all-rooms />
            </div>

            <div class="w-full px-4 lg:w-2/3">
                <livewire:chat.messages :room="$room" />
            </div>
        </div>
    </div>
</div>

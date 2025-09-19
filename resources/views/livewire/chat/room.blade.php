<div class="mx-auto mt-4">
    <div class="bg-gray-100/25">
        <div class="flex flex-col-reverse sm:flex-row sm:flex-wrap">
            <div class="w-full px-4 sm:w-1/3">
                <div class="mb-4">
                    <livewire:chat.all-rooms />
                </div>

                <livewire:chat.invited :room="$room" />

                @if ($room->private)
                    <livewire:chat.user-select :room="$room" />
                @endif
            </div>

            <div class="w-full px-4 sm:w-2/3">
                <livewire:chat.messages id="chat-messages" :room="$room" />
            </div>
        </div>
    </div>
</div>

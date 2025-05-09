<div class="mx-auto mt-4">
    <div class="bg-gray-100/25">
        <div class="flex sm:flex-wrap flex-col-reverse sm:flex-row">
            <div class="w-full sm:w-1/3 px-4">
                <div class="mb-4">
                    <livewire:chat.all-rooms/>
                </div>

                <livewire:chat.invited :room="$room"/>

                @if ($room->private)
                    <livewire:chat.user-select :room="$room"/>
                @endif
            </div>

            <div class="w-full sm:w-2/3 px-4">
                <livewire:chat.messages id="chat-messages" :room="$room"/>
            </div>
        </div>
    </div>
</div>

<div class="h-[500px]">
    <div id="chat-box" class="block h-5/6 overflow-y-scroll">
        <ul class="p-2 md:p-4 bg-gray-100 rounded-lg shadow-lg">
            @foreach($chats->sortBy('created_at') as $chat)
                <li class="mb-4" wire:key="{{ $chat->id }}">
                    <div class="flex items-center mb-2">
                        <span class="text-gray-500 mr-2">{{ $chat->created_at->appTimezone()->format('Y-m-d H:i') }}</span>
                        <span class="font-semibold">{{ $chat->user->name }}</span>
                    </div>
                    <p class="text-gray-800">{{ $chat->message }}</p>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="h-1/6 mb-0 p-2 md:p-4 w-full bg-emerald-100 border border-emerald-700">
        <form wire:submit="postMessage">
            <div class="flex">
                <x-forms.input-label class="inline-flex grow-0" for="new_chat"/>
                <x-forms.text-input type="text" class="grow mx-2" id="new_chat" name="new_chat" autofocus wire:model="new_chat"/>
                <x-forms.secondary-button type="submit">Send</x-forms.secondary-button>
            </div>
            <small class="block ml-2">
                Character left: <span x-text="$wire.new_chat ? 150 - $wire.new_chat.length : 150"></span>
                <x-forms.input-error class="mt-2 ml-2" :messages="$errors->get('new_chat')"/>
            </small>
        </form>
    </div>
</div>

@push('js')
    <script>
        window.addEventListener('load',  () => {
            console.log('messages blade file loaded')
            console.log(Echo.socketId())
            const roomId = {{ $room->id }};
            //const user = '{{ auth()->user()->name }}';
            //let users = {{ Js::from($room->users()->get(['id', 'name'])) }};
            console.log('room is '+`chat-${roomId}`)
            console.log(`chat.${roomId}`);

            Echo.join(`chat.${roomId}`)
                .subscribed(() => {
                    console.log(roomId, "Subscribed to presence chat." + roomId);
                })
                .here((members) => {
                    console.log("List of members: " + JSON.stringify(members));
                })
                .joining((user) => {
                    console.log('joining ' + user?.name);
                })
                .leaving((user) => {
                    console.log(data, "left room");
                })
                .error((error) => {
                    console.error(error);
                })
                .listenToAll((eventName, data) => {
                    console.log("Event ::  "+ eventName + ", data is ::" + JSON.stringify(data));
                })
                /*.listen('MessagePosted', (e) => {
                    console.log(e);
                })*/;
        });
        /*Livewire.hook('request', ({ succeed }) => {
            succeed(() => {
                const el_chat = document.getElementById('chat-box');
                el_chat.scrollTo({ top: el_chat.scrollHeight, behavior: "smooth" });
            })
        })*/
    </script>
@endpush


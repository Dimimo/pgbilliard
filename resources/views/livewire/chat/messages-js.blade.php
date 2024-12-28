@push('js')
    <script>
        window.addEventListener('load', () => {
            console.log('messages blade file loaded')
            console.log(Echo.socketId())
            const roomId = {{ $room->id }};
            // const user = '{{ auth()->user()->name }}';
            // let users = {{ Js::from($room->users()->get(['id', 'name'])) }};
            console.log('room is ' + `chat-${roomId}`)
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
                    console.log(user, "left room");
                })
                .error((error) => {
                    console.error(error);
                })
                .listenToAll((eventName, data) => {
                    console.log("Event ::  " + eventName + ", data is ::" + JSON.stringify(data));
                })
            /*.listen('MessagePosted', (e) => {
                console.log(e);
            })*/;
        });
        Livewire.hook('request', ({ succeed }) => {
            succeed(() => {
                const el_chat = document.getElementById('chat-box');
                el_chat.scrollTo({ top: el_chat.scrollHeight, behavior: "smooth" });
            })
        })
    </script>
@endpush

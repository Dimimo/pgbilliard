<div class="my-4 border border-orange-400 bg-orange-50 p-4">
    <p class="mb-2">
        <span class="font-bold">Warning:</span> this chat seems to work, except for
        <a class="text-blue-800" href="https://laravel.com/docs/11.x/broadcasting" target="_blank">the broadcasting</a>
        of messages. This means, <span class="font-bold">your message will not yet be seen by somebody else
                in the same room at the same time</span>.
    </p>
    <p class="mb-2">
        This feature is easily implemented with services as
        <a class="text-blue-800" href="https://pusher.com/channels" target="_blank">Pusher Channels</a> or
        <a class="text-blue-800" href="https://github.com/ably/laravel-broadcaster" target="_blank">Ably</a> but
        the free version has its limitations of 2.000 interactions a day. This seems much. But it isn't if you plan
        to use the chat frequently.
    </p>
    <p class="mb-2">
        <span class="font-bold">For example:</span> 10 people are in the chat = 10 interactions per post. Including when
        people join or leave. The optional but nice <span class="italic">whisper</span> functionality
        <span class="italic">(John Doe is typing...)</span> adds to the interactions.
    </p>
    <p class="mb-2">
        In the mean time: <span class="font-bold">your posts are recorded in the database</span> and will appear 'live'
        to you but not to others. There are
        <a class="text-blue-800" href="https://github.com/laravel/echo" target="_blank">free alternatives</a> but
        far more difficult to implement... and to test.
    </p>
    <p class="text-center text-lg font-bold">
        So please be patient, it will be alright!<br>
        Work in progress...
    </p>
</div>

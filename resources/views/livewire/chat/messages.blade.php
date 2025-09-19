<div class="h-[500px]">
    <div id="chat-box" class="block h-5/6 overflow-y-scroll">
        <ul class="rounded-lg bg-gray-100 p-2 shadow-lg md:p-4">
            @foreach ($chats as $chat)
                <li class="mb-4" wire:key="{{ $chat->id }}">
                    <div class="mb-2 flex items-center">
                        <span class="mr-2 text-gray-500">
                            {{ $chat->created_at->appTimezone()->diffForHumans() }}
                        </span>
                        <span class="font-semibold">{{ $chat->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <div class="text-gray-800">{{ $chat->message }}</div>
                        @can('delete', $chat)
                            <button
                                wire:confirm="{{ __('Are you sure to delete your message') }}?"
                                wire:click="deleteMessage({{ $chat->id }})"
                            >
                                <x-svg.trash-can-solid color="fill-gray-500" size="4" />
                            </button>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div
        class="mb-0 h-1/6 w-full border border-emerald-700 bg-emerald-100 p-2 md:p-4"
        x-data="{ new_chat: '' }"
    >
        <form wire:submit="postMessage">
            <div class="flex">
                <x-forms.input-label class="inline-flex grow-0" for="new_chat" />
                <x-forms.text-input
                    type="text"
                    class="mx-2 grow"
                    id="new_chat"
                    autofocus
                    wire:model.live.debounce.500ms="new_chat"
                />
                <x-forms.secondary-button type="submit">
                    {{ __('Send') }}
                </x-forms.secondary-button>
            </div>
            <small class="ml-2 block">
                {{ __('Character left') }}:
                <span
                    x-text="$wire.new_chat ? {{ $max_chars }} - $wire.new_chat.length : {{ $max_chars }}"
                ></span>
                <x-forms.input-error class="ml-2 mt-2" :messages="$errors->get('new_chat')" />
                <x-forms.action-message on="message-deleted">
                    {{ __('Message deleted') }}
                </x-forms.action-message>
            </small>
        </form>
    </div>

    @script
        <script>
            //const el_chat = document.getElementById('chat-box');
            /*$wire.hook('request', ({ succeed }) => {
            succeed(() => {

                el_chat.scrollTo({ top: el_chat.scrollHeight/!*, behavior: "smooth"*!/ });
            })
        });*/
            document.addEventListener(
                'livewire:navigated',
                () => {
                    setInterval(() => {
                        const el_chat = document.getElementById('chat-box');
                        Livewire.dispatch('refresh-messages');
                        el_chat.scrollTo({ top: el_chat.scrollHeight, behavior: 'smooth' });
                    }, 2000);
                },
                { once: true },
            );
        </script>
    @endscript
</div>

<div>
    @if(session('is_admin'))
        <div class="my-8 flex flex-row items-center space-x-2">
            <button
                type="button"
                class="rounded-lg border border-indigo-700 bg-indigo-100 px-4 py-2"
                wire:click="requestUpdate"
            >
                Request update
            </button>
            <div>
                <x-forms.action-message on="updated">Updated!</x-forms.action-message>
            </div>
        </div>
    @endif
    <ul>
        @foreach($results->take(30) as $result)
            <li>
                <span class="mr-2 font-bold">{{ $rank++ }}</span>{{ $result->percentage }}% - {{ $result->user->name }}
                with {{ $result->won }} games won
                out of {{ $result->played }} total played games
                and {{ $result->lost }} games lost
                with a total participation of {{ $result->participated }} events
            </li>
        @endforeach
    </ul>

    @script
    <script>
        let echoPublicChannel = window.Echo.channel('refresh-requested');
        let ablyPublicChannelName = echoPublicChannel.name;
        console.log(ablyPublicChannelName);
        $wire.on('refresh-requested', () => {
            console.log('refresh requested');
            $wire.$commit();
        });
    </script>
    @endscript
</div>

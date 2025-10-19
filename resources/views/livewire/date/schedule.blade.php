<div>
    <livewire:date.schedule-format-chooser :event="$event" :format="$format" :switches="$switches" />

    @if (! $switches->get('chooseFormat'))
        <!-- start selecting the players -->
        <livewire:date.schedule-player-selector :season="$season" :event="$event" :format="$format" :switches="$switches" />
        <!-- end selecting the players -->

        <!-- start the individual scores table -->
        <livewire:date.schedule-score-table :season="$season" :event="$event" :switches="$switches" />
        <!-- end the individual scores table -->

        <!-- start the schedule confirmation component -->
        <livewire:date.schedule-confirm :season="$season" :event="$event" />
        <!-- end the schedule confirmation component -->
    @endif

    @script
        <script>
            let echoPublicChannel = window.Echo.channel('live-score');
            let ablyPublicChannelName = echoPublicChannel.name;
            console.log(ablyPublicChannelName);
        </script>
    @endscript
</div>

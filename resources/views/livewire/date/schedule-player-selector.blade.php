<div class="grid grid-flow-row grid-cols-8 items-center justify-items-center gap-2">
    <div class="relative col-span-8">
        @if (! $switches->get('confirmed'))
            <x-schedule.info-box-before-first-game
                :event="$event"
                :format="$format->name"
                :switches="$switches"
            />
        @endif
    </div>
    <div class="relative col-span-4 h-full w-full bg-blue-50 p-4 text-right">
        <x-schedule.players-dropdown
            key="home-matrix-players"
            :event="$event"
            :players="$home_players"
            place="home"
            :matrix="$home_matrix"
            :switches="$switches"
        />
    </div>
    <div class="col-span-4 h-full w-full bg-green-50 p-4 text-left">
        <x-schedule.players-dropdown
            key="visit-matrix-players"
            :event="$event"
            :players="$visit_players"
            place="visit"
            :matrix="$visit_matrix"
            :switches="$switches"
        />
    </div>
</div>

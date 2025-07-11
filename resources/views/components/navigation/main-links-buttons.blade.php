<div class="relative flex justify-center md:mb-1">
    <div class="grid grid-cols-1 gap-2 md:grid-cols-3 md:gap-4">
        <a href="{{ route('scoreboard') }}" wire:navigate.hover>
            <div
                class="flex items-center justify-center rounded-full border border-green-500 bg-green-100 px-3 py-1 text-3xl space-x-2 md:py-3 lg:space-mx-4"
            >
                <x-svg.table-list-solid color="fill-green-600" size="7" padding=""/>
                <div>{{__('Scoreboard')}}</div>
            </div>
        </a>
        <a href="{{ route('calendar') }}" wire:navigate.hover>
            <div
                class="flex items-center justify-center rounded-full border border-blue-600 bg-blue-100 px-3 py-1 text-3xl space-x-2 md:py-3 lg:space-mx-4">
                <x-svg.calendar-days-solid color="fill-blue-600" size="7" padding=""/>
                <div>{{__('Calendar')}}</div>
            </div>
        </a>
        <a href="{{ route('teams.index') }}" wire:navigate.hover>
            <div
                class="flex items-center justify-center rounded-full border border-amber-500 bg-amber-100 px-3 py-1 text-3xl space-x-2 md:py-3 lg:space-mx-4"
            >
                <x-svg.users-solid color="fill-amber-500" size="7" padding=""/>
                <div>{{__('Teams')}}</div>
            </div>
        </a>
    </div>
</div>

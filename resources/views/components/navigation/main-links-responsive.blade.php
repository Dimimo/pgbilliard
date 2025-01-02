<div class="pt-2 pb-3 space-y-1">
    <x-forms.responsive-nav-link href="{{ route('scoreboard') }}" :active="request()->routeIs('scoreboard')" wire:navigate>
        <x-svg.table-list-solid color="fill-gray-600" size="5" padding="mr-4"/>
        Scoreboard
    </x-forms.responsive-nav-link>
</div>
<div class="pt-2 pb-3 space-y-1">
    <x-forms.responsive-nav-link href="{{ route('calendar') }}" :active="request()->routeIs(['calendar', 'calendar'])" wire:navigate>
        <x-svg.calendar-days-solid color="fill-gray-600" size="5" padding="mr-4"/>
        Calendar
    </x-forms.responsive-nav-link>
</div>
<div class="pt-2 pb-3 space-y-1">
    <x-forms.responsive-nav-link href="{{ route('teams.index') }}" :active="request()->routeIs(['teams', 'teams.*'])" wire:navigate>
        <x-svg.users-solid color="fill-gray-600" size="5" padding="mr-4"/>
        Teams
    </x-forms.responsive-nav-link>
</div>
@auth()
    <div class="pt-2 pb-3 space-y-1">
        <x-forms.responsive-nav-link href="{{ route('chat.index') }}" :active="request()->routeIs(['chat', 'chat.*'])" wire:navigate>
            <x-svg.comments-solid color="fill-gray-600" size="5" padding="mr-4"/>
            Chat
        </x-forms.responsive-nav-link>
    </div>
@endauth
<div class="pt-2 pb-3 space-y-1">
    <x-forms.responsive-nav-link href="{{ route('forum.posts.index') }}" :active="request()->routeIs('forum.posts.*')" wire:navigate>
        <x-svg.paw-solid color="fill-gray-600" size="5" padding="mr-4"/>
        Forum
    </x-forms.responsive-nav-link>
</div>

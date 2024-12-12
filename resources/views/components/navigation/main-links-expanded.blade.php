<div class="flex sm:space-x-6">
    <!-- Logo -->
    <div class="hidden shrink-0 items-center md:flex">
        <a href="{{ route('scoresheet') }}" wire:navigate>
            <x-application-logo class="block h-9 w-auto"/>
        </a>
    </div>
    <div class="hidden sm:-my-px sm:flex md:ml-4">
        <x-forms.nav-link href="{{ route('scoresheet') }}" :active="request()->routeIs('scoresheet')" wire:navigate>
            Scoresheet
        </x-forms.nav-link>
    </div>
    <div class="hidden space-x-4 sm:-my-px sm:ml-4 sm:flex">
        <x-forms.nav-link href="{{ route('calendar') }}" :active="request()->routeIs('calendar')" wire:navigate>
            Calendar
        </x-forms.nav-link>
    </div>
    <div class="hidden space-x-4 sm:-my-px sm:ml-4 sm:flex">
        <x-forms.nav-link href="{{ route('teams') }}" :active="request()->routeIs('teams.*')" wire:navigate>
            Teams
        </x-forms.nav-link>
    </div>
    @auth()
        <div class="hidden space-x-4 sm:-my-px sm:ml-4 sm:flex">
            <x-forms.nav-link href="{{ route('chat.index') }}" :active="request()->routeIs('chat.*')" wire:navigate>
                Chat
            </x-forms.nav-link>
        </div>
    @endauth
    <div class="hidden space-x-4 sm:-my-px sm:ml-4 sm:flex">
        <x-forms.nav-link href="{{ route('forum.posts.index') }}" :active="request()->routeIs('forum.posts.*')" wire:navigate>
            Forum
        </x-forms.nav-link>
    </div>
</div>
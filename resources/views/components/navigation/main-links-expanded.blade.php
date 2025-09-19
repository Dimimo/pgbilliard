<div class="mb-1 flex sm:space-x-4 md:space-x-8">
    <!-- Logo -->
    <div class="hidden shrink-0 items-center md:flex">
        <a href="{{ route('dashboard') }}" wire:navigate title="{{ __('Your Dashboard') }}">
            <x-application-logo class="block h-6 w-auto" />
        </a>
    </div>
    <div class="hidden sm:-my-px sm:flex md:ml-4">
        <x-forms.nav-link
            href="{{ route('scoreboard') }}"
            :active="request()->routeIs('scoreboard')"
            wire:navigate
        >
            {{ __('Scoreboard') }}
        </x-forms.nav-link>
    </div>
    <div class="hidden space-x-4 sm:-my-px sm:ml-4 sm:flex">
        <x-forms.nav-link
            href="{{ route('calendar') }}"
            :active="request()->routeIs('calendar')"
            wire:navigate
        >
            {{ __('Calendar') }}
        </x-forms.nav-link>
    </div>
    <div class="hidden space-x-4 sm:-my-px sm:ml-4 sm:flex">
        <x-forms.nav-link
            href="{{ route('teams.index') }}"
            :active="request()->routeIs('teams.index')"
            wire:navigate
        >
            {{ __('Teams') }}
        </x-forms.nav-link>
    </div>
    {{--
        @auth()
        <div class="hidden space-x-4 sm:-my-px sm:ml-4 sm:flex">
        <x-forms.nav-link href="{{ route('chat.index') }}" :active="request()->routeIs('chat.*')" wire:navigate>
        {{__('Chat')}}
        </x-forms.nav-link>
        </div>
        @endauth
    --}}
    <div class="hidden space-x-4 sm:-my-px sm:ml-4 sm:flex">
        <x-forms.nav-link
            href="{{ route('forum.posts.index') }}"
            :active="request()->routeIs('forum.posts.*')"
            wire:navigate
        >
            {{ __('Forum') }}
        </x-forms.nav-link>
    </div>
</div>

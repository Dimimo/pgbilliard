<?php
use function Livewire\Volt\uses;
use App\Livewire\WithCurrentCycle;

uses([WithCurrentCycle::class]);

$logout = function () {
    auth()->guard('web')->logout();
    session()->invalidate();
    session()->regenerateToken();
    $this->redirect('/dashboard', navigate: true);
};
?>

<nav x-data="{ open: false }" class="border-b border-gray-100 bg-white">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto max-w-7xl px-2 md:px-4 lg:px-6">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="hidden shrink-0 items-center md:flex">
                    <a href="{{ route('scoresheet') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto"/>
                    </a>
                </div>
                <div class="hidden space-x-4 sm:-my-px sm:flex md:ml-4">
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
                    <x-forms.nav-link href="{{ route('teams') }}" :active="request()->routeIs('teams')" wire:navigate>
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

            <!-- Settings Dropdown -->
            @auth()
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-2 sm:flex-row">
                    @if(auth()->user()->isAdmin())
                        <x-forms.dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                    title="Profile related"
                                >
                                    <div>{{ __("ADMIN") }}</div>

                                    <div class="ml-1">
                                        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-forms.dropdown-link :href="route('admin.venues.create')" wire:navigate>
                                    {{ __('Create a new Venue') }}
                                </x-forms.dropdown-link>

                                <x-forms.dropdown-link :href="route('admin.seasons.create')" wire:navigate>
                                    {{ __('Create a new Season') }}
                                </x-forms.dropdown-link>

                                <x-forms.dropdown-link :href="route('admin.schedule.index')" wire:navigate>
                                    {{ __('Day Schedules') }}
                                </x-forms.dropdown-link>

                                <hr class="my-2 w-fill border-b border-b-indigo-700">

                                <x-forms.dropdown-link :href="route('admin.calendar.update', ['season' => $season])" wire:navigate>
                                    {{ __('Update the Calendar') }}
                                </x-forms.dropdown-link>

                                <x-forms.dropdown-link :href="route('admin.season.update', ['season' => $season])" wire:navigate>
                                    {{ __('Update Season structure') }}
                                </x-forms.dropdown-link>

                                <hr class="my-2 w-fill border-b border-b-indigo-700">

                                <x-forms.dropdown-link :href="route('admin.overview')" wire:navigate>
                                    {{ __('List of admins') }}
                                </x-forms.dropdown-link>
                            </x-slot>
                        </x-forms.dropdown>
                    @endif

                    <x-forms.dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center rounded-md border border-transparent bg-white px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                title="{{ __('Profile related') }}"
                            >
                                <div
                                    x-data="{ name: '{{ auth()->user()->name }}' }"
                                    x-text="name"
                                    x-on:profile-updated.window="name = $event.detail.name"
                                ></div>

                                <div class="ml-1">
                                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-forms.dropdown-link :href="route('dashboard')" wire:navigate>
                                {{ __('Dashboard') }}
                            </x-forms.dropdown-link>

                            <x-forms.dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-forms.dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-left">
                                <x-forms.dropdown-link>
                                    {{ __('Log Out') }}
                                </x-forms.dropdown-link>
                            </button>
                        </x-slot>
                    </x-forms.dropdown>
                </div>
            @else
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-2 sm:flex-row">
                    <x-forms.dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center rounded-md border border-transparent bg-white px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                title="{{ __('Profile related') }}"
                            >
                                <div>Log In / Register</div>

                                <div class="ml-1">
                                    <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-forms.dropdown-link :href="route('login')" wire:navigate>
                                {{ __('Log in') }}
                            </x-forms.dropdown-link>

                            <x-forms.dropdown-link :href="route('players.accounts')" wire:navigate>
                                {{ __('Claim your account') }}
                            </x-forms.dropdown-link>

                            <x-forms.dropdown-link :href="route('register')" wire:navigate>
                                {{ __('Register') }}
                            </x-forms.dropdown-link>
                        </x-slot>
                    </x-forms.dropdown>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{'hidden': open, 'inline-flex': ! open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2" d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{'hidden': ! open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-forms.responsive-nav-link href="{{ route('scoresheet') }}" :active="request()->routeIs('scoresheet')" wire:navigate>
                Scoresheet
            </x-forms.responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-forms.responsive-nav-link href="{{ route('calendar') }}" :active="request()->routeIs(['calendar', 'calendar.*'])" wire:navigate>
                Calendar
            </x-forms.responsive-nav-link>
        </div>
        @auth()
            <div class="pt-2 pb-3 space-y-1">
                <x-forms.responsive-nav-link href="{{ route('chat.index') }}" :active="request()->routeIs('chat.*')" wire:navigate>
                    Chat
                </x-forms.responsive-nav-link>
            </div>
        @endauth
        <div class="pt-2 pb-3 space-y-1">
            <x-forms.responsive-nav-link href="{{ route('forum.posts.index') }}" :active="request()->routeIs('forum.posts.*')" wire:navigate>
                Forum
            </x-forms.responsive-nav-link>
        </div>

        @auth()
            <!-- Responsive Settings Options -->
            <div class="border-t border-gray-200 pt-4 pb-1">
                <div class="px-4">
                    <div
                        class="text-base font-medium text-gray-800"
                        x-data="{ name: '{{ auth()->user()->name }}' }"
                        x-text="name"
                        x-on:profile-updated.window="name = $event.detail.name"
                    ></div>
                    <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-forms.responsive-nav-link :href="route('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-forms.responsive-nav-link>

                    <x-forms.responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-forms.responsive-nav-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-left">
                        <x-forms.responsive-nav-link>
                            {{ __('Log Out') }}
                        </x-forms.responsive-nav-link>
                    </button>
                </div>
            </div>
            @else
            <!-- Responsive Log in Options -->
            <div class="border-t border-gray-200 pt-4 pb-1">
                <div class="px-4">
                    <div class="text-sm font-medium text-gray-800">Log In / Register</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-forms.responsive-nav-link :href="route('login')" wire:navigate>
                        {{ __('Log in') }}
                    </x-forms.responsive-nav-link>

                    <x-forms.responsive-nav-link :href="route('players.accounts')" wire:navigate>
                        {{ __('Claim your account') }}
                    </x-forms.responsive-nav-link>

                    <x-forms.responsive-nav-link :href="route('register')" wire:navigate>
                        {{ __('Register') }}
                    </x-forms.responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>

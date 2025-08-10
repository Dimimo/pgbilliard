<?php

use function Livewire\Volt\uses;
use App\Livewire\WithCurrentCycle;

uses([WithCurrentCycle::class]);

$logout = function () {
    auth()->guard('web')->logout();
    session()->invalidate();
    session()->forget('is_admin');
    session()->regenerateToken();
    $this->redirect('/');
};
?>

<nav x-data="{ open: false }" class="bg-gradient-to-b from-blue-200 pt-2 pb-4">
    <div class="container mx-auto flex-grow sm:px-4 md:px-12 lg:px-24">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-7xl px-2 md:px-4 lg:px-6">
            <div class="flex h-16 justify-between">
                <div class="flex h-16 grow justify-between items-center">

                    <x-navigation.main-links-expanded/>

                    <!-- Settings Dropdown -->
                    @auth()
                        <div class="hidden sm:space-x-2 sm:ml-6 sm:flex sm:flex-row sm:items-center">
                            <!-- Admin Dropdown -->
                            @if(session('is_admin'))

                                <x-navigation.admin-dropdown-expanded :season="$season"/>

                            @endif

                            <!-- User logged in Dropdown -->
                            <x-navigation.users-logged-in-expanded/>

                        </div>
                    @else
                        <!-- Visitors Dropdown -->
                        <div class="hidden sm:space-x-2 sm:ml-6 sm:flex sm:flex-row sm:items-center">

                            <x-navigation.visitors-expanded/>

                        </div>
                    @endauth

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button
                            @click="open = ! open"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-800 transition duration-150 ease-in-out hover:bg-transparent hover:text-gray-600 focus:bg-gray-50 focus:text-gray-600 focus:outline-none"
                        >
                            <div class="mr-4">
                                <div x-show="! open">Open Menu</div>
                                <div x-show="open">Close</div>
                            </div>
                            <svg class="h-6 w-6 bg-transparent" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    :class="{'hidden': open, 'inline-flex': ! open }"
                                    class="inline-flex"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
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

                <div class="mt-1 ml-6 flex flex-none flex-row items-center space-x-2">
                    <x-navigation.help-files-expanded/>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white">

            <x-navigation.main-links-responsive/>

            @auth()

                <!-- Responsive Settings Options -->
                <x-navigation.users-logged-in-responsive/>

            @else

                <!-- Responsive Log in Options -->
                <x-navigation.visitors-responsive/>

            @endauth
        </div>
    </div>
</nav>

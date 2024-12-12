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

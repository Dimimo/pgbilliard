<div class="border-t border-gray-200 pb-1 pt-4">
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
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"
                class="mr-4 inline-block h-5 w-5 fill-gray-600"
            >
                <path
                    d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM288 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM256 416c35.3 0 64-28.7 64-64c0-17.4-6.9-33.1-18.1-44.6L366 161.7c5.3-12.1-.2-26.3-12.3-31.6s-26.3 .2-31.6 12.3L257.9 288c-.6 0-1.3 0-1.9 0c-35.3 0-64 28.7-64 64s28.7 64 64 64zM176 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM96 288a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm352-32a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"
                />
            </svg>
            {{ __('Dashboard') }}
        </x-forms.responsive-nav-link>

        <x-forms.responsive-nav-link :href="route('profile')" wire:navigate>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 576 512"
                class="mr-4 inline-block h-5 w-5 fill-gray-600"
            >
                <path
                    d="M0 96l576 0c0-35.3-28.7-64-64-64L64 32C28.7 32 0 60.7 0 96zm0 32L0 416c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-288L0 128zM64 405.3c0-29.5 23.9-53.3 53.3-53.3l117.3 0c29.5 0 53.3 23.9 53.3 53.3c0 5.9-4.8 10.7-10.7 10.7L74.7 416c-5.9 0-10.7-4.8-10.7-10.7zM176 192a64 64 0 1 1 0 128 64 64 0 1 1 0-128zm176 16c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16z"
                />
            </svg>
            {{ __('Profile') }}
        </x-forms.responsive-nav-link>

        <!-- Authentication -->
        <button wire:click="logout" class="w-full text-left">
            <x-forms.responsive-nav-link>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    class="mr-4 inline-block h-5 w-5 fill-red-600"
                >
                    <path
                        d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z"
                    />
                </svg>
                {{ __('Log Out') }}
            </x-forms.responsive-nav-link>
        </button>
    </div>
</div>

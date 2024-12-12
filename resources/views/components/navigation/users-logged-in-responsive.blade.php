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
            <x-svg.gauge-high-solid color="fill-gray-600" size="5" padding="mr-4" padding="mr-4"/>
            {{ __('Dashboard') }}
        </x-forms.responsive-nav-link>

        <x-forms.responsive-nav-link :href="route('profile')" wire:navigate>
            <x-svg.id-card-solid color="fill-gray-600" size="5" padding="mr-4"/>
            {{ __('Profile') }}
        </x-forms.responsive-nav-link>

        <!-- Authentication -->
        <button wire:click="logout" class="w-full text-left">
            <x-forms.responsive-nav-link>
                <x-svg.right-to-bracket-solid color="fill-red-600" size="5" padding="mr-4"/>
                {{ __('Log Out') }}
            </x-forms.responsive-nav-link>
        </button>
    </div>
</div>

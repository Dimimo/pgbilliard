@props(['season'])
<x-forms.dropdown align="right" width="48">
    <x-slot name="trigger">
        <button
            class="inline-flex items-center rounded-md border border-transparent bg-transparent px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
            title="{{ __('Administration') }}"
        >
            <div>{{ __("ADMIN") }}</div>

            <div class="ml-1">
                <svg
                    class="h-4 w-4 fill-current"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                >
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
        <x-forms.dropdown-link :href="route('admin.index')" wire:navigate>
            {{ __('Overview and Help') }}
        </x-forms.dropdown-link>

        <hr class="w-fill my-2 border-b border-b-indigo-700" />

        <x-forms.dropdown-link :href="route('admin.venues.create')" wire:navigate>
            {{ __('Create a new Venue') }}
        </x-forms.dropdown-link>

        <x-forms.dropdown-link :href="route('admin.seasons.create')" wire:navigate>
            {{ __('Create a new Season') }}
        </x-forms.dropdown-link>

        <x-forms.dropdown-link :href="route('admin.schedule.index')" wire:navigate>
            {{ __('Day Schedules') }}
        </x-forms.dropdown-link>

        <hr class="w-fill my-2 border-b border-b-indigo-700" />

        <x-forms.dropdown-link
            :href="route('admin.season.update', ['season' => $season])"
            wire:navigate
        >
            {{ __('Update Season structure') }}
        </x-forms.dropdown-link>

        <x-forms.dropdown-link
            :href="route('admin.calendar.update', ['season' => $season])"
            wire:navigate
        >
            {{ __('Update the Calendar') }}
        </x-forms.dropdown-link>

        <x-forms.dropdown-link
            :href="route('admin.calendar.shift', ['season' => $season])"
            wire:navigate
        >
            {{ __('Change a playing date') }}
        </x-forms.dropdown-link>

        <hr class="w-fill my-2 border-b border-b-indigo-700" />

        <x-forms.dropdown-link :href="route('admin.contact')" wire:navigate>
            {{ __('Send emails to players') }}
        </x-forms.dropdown-link>

        <x-forms.dropdown-link :href="route('admin.players.overview')" wire:navigate>
            {{ __('Overview of players') }}
        </x-forms.dropdown-link>

        <x-forms.dropdown-link :href="route('admin.overview')" wire:navigate>
            {{ __('List of admins') }}
        </x-forms.dropdown-link>

        <x-forms.dropdown-link :href="route('logs')" wire:navigate>
            {{ __('Score changes log file') }}
        </x-forms.dropdown-link>
    </x-slot>
</x-forms.dropdown>

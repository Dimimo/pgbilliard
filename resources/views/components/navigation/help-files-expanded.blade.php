<x-forms.dropdown width="48">
    <x-slot name="trigger">
        <button
            class="inline-flex items-center rounded-md border border-transparent bg-transparent px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
            title="The Help Files"
        >
            <div>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    class="inline-block w-5 h-5 fill-green-600 mb-1"
                >
                    <path
                        d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3l58.3 0c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24l0-13.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1l-58.3 0c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/>
                </svg>
            </div>
        </button>
    </x-slot>
    <x-slot name="content">
        <x-forms.dropdown-link :href="route('help.rules')" wire:navigate>
            {{ __('OUR BILLIARD RULES') }}
        </x-forms.dropdown-link>
        <hr class="my-2 border-b border-b-indigo-700 w-fill">

        <div class="ml-12 text-sm text-blue-800">Main sections</div>
        <x-forms.dropdown-link :href="route('help.results')" wire:navigate>
            {{ __('Scoreboard explained') }}
        </x-forms.dropdown-link>
        <x-forms.dropdown-link :href="route('help.ranking')" wire:navigate>
            {{ __('The Individual Ranking') }}
        </x-forms.dropdown-link>
        <x-forms.dropdown-link :href="route('help.calendar')" wire:navigate>
            {{ __('The Calendar') }}
        </x-forms.dropdown-link>
        <x-forms.dropdown-link :href="route('help.live-scores')" wire:navigate>
            {{ __('The day scores overview') }}
        </x-forms.dropdown-link>
        <x-forms.dropdown-link :href="route('help.schedule')" wire:navigate>
            <x-svg.eye-solid color="fill-blue-600" size="4"/>
            {{ __('Detailed schedules') }}
        </x-forms.dropdown-link>
        <x-forms.dropdown-link :href="route('help.teams')" wire:navigate>
            {{ __('Participating Teams') }}
        </x-forms.dropdown-link>
        <hr class="my-2 border-b border-b-indigo-700 w-fill">

        <div class="ml-12 text-sm text-blue-800">Other</div>
        {{--<x-forms.dropdown-link :href="route('help.chat')" wire:navigate>
            {{ __('The chat and rooms') }}
        </x-forms.dropdown-link>--}}
        <x-forms.dropdown-link :href="route('logs')" wire:navigate>
            {{ __('Score changes log file') }}
        </x-forms.dropdown-link>
        <x-forms.dropdown-link :href="route('help.changelog')" wire:navigate>
            {{ __('Website changelog') }}
        </x-forms.dropdown-link>

        @if(session('is_admin'))
            <hr class="my-2 border-b border-b-indigo-700 w-fill">

            <div class="ml-12 text-sm text-blue-800">Admin only</div>

            <x-forms.dropdown-link :href="route('admin.help.overview')" wire:navigate>
                {{ __('General overview') }}
            </x-forms.dropdown-link>
            <x-forms.dropdown-link :href="route('admin.help.structure')" wire:navigate>
                {{ __('Season Structure') }}
            </x-forms.dropdown-link>
            <x-forms.dropdown-link :href="route('admin.help.calendar')" wire:navigate>
                {{ __('Calendar Creation') }}
            </x-forms.dropdown-link>
            <x-forms.dropdown-link :href="route('admin.help.schedule')" wire:navigate>
                {{ __('Day Schedule blueprint') }}
            </x-forms.dropdown-link>
        @endif

    </x-slot>
</x-forms.dropdown>

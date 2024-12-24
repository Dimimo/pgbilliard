<x-forms.dropdown width="48">
    <x-slot name="trigger">
        <button
            class="inline-flex items-center rounded-md border border-transparent bg-transparent px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
            title="Profile related"
        >
            <div>
                <x-svg.circle-question-solid color="fill-green-600" size="5"/>
            </div>
        </button>
    </x-slot>
    <x-slot name="content">
        <x-forms.dropdown-link :href="route('help.results')" wire:navigate>
            {{ __('Scoresheet explained') }}
        </x-forms.dropdown-link>
        <x-forms.dropdown-link :href="route('help.calendar')" wire:navigate>
            {{ __('The Calendar') }}
        </x-forms.dropdown-link>

        @if(auth()->user()?->isAdmin())
            <hr class="my-2 border-b border-b-indigo-700 w-fill">

            <div class="ml-12 text-sm text-blue-800">Admin only</div>

            <x-forms.dropdown-link :href="route('admin.help.overview')" wire:navigate>
                {{ __('General overview') }}
            </x-forms.dropdown-link>
        @endif

    </x-slot>
</x-forms.dropdown>

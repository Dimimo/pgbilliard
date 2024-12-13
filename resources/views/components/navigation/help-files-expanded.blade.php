<x-forms.dropdown align="left" width="48">
    <x-slot name="trigger">
        <button
            class="inline-flex items-center rounded-md border border-transparent bg-white px-1 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
            title="Profile related"
        >
            <div>
                <x-svg.circle-question-solid color="fill-green-600" size="5"/>
            </div>
        </button>
    </x-slot>
    <x-slot name="content">
        <x-forms.dropdown-link :href="route('help.results')" wire:navigate>
            {{ __('The Scoresheet page') }}
        </x-forms.dropdown-link>


    </x-slot>
</x-forms.dropdown>

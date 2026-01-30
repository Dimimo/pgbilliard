<x-help.help-layout :help="$help">
    @switch(app()->getLocale())
        @case('nl')
            <x-help.nl.calendar />

            @break
        @default
            <x-help.calendar />
    @endswitch
</x-help.help-layout>

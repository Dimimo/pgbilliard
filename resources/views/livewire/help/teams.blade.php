<x-help.help-layout :help="$help">
    @switch(app()->getLocale())
        @case('nl')
            <x-help.nl.teams />

            @break
        @default
            <x-help.teams />
    @endswitch
</x-help.help-layout>

<x-help.help-layout :help="$help">
    @switch(app()->getLocale())
        @case('nl')
            <x-help.nl.schedule />

            @break
        @default
            <x-help.schedule />
    @endswitch
</x-help.help-layout>

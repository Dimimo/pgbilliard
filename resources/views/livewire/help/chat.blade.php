<x-help.help-layout :help="$help">
    @switch(app()->getLocale())
        @case('nl')
            <x-help.nl.chat />

            @break
        @default
            <x-help.chat />
    @endswitch
</x-help.help-layout>

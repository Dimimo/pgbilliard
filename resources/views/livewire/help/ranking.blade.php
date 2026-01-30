<x-help.help-layout :help="$help">
    @switch(app()->getLocale())
        @case('nl')
            <x-help.nl.ranking />

            @break
        @default
            <x-help.ranking />
    @endswitch
</x-help.help-layout>

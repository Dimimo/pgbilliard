<x-help.help-layout :help="$help">
    @switch(app()->getLocale())
        @case('nl')
            <x-help.nl.competition-results />

            @break
        @default
            <x-help.competition-results />
    @endswitch
</x-help.help-layout>

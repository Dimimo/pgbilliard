<x-help.help-layout :help="$help">
    @switch(app()->getLocale())
        @case('nl')
            <x-help.nl.live-scores />

            @break
        @default
            <x-help.live-scores />
    @endswitch
</x-help.help-layout>

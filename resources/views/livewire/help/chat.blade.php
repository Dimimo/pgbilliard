<x-help.help-layout :help="$help">
    @include('components.help.'.app()->getLocale().'.chat')
</x-help.help-layout>

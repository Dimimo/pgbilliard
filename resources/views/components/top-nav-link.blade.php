@php
    request()->is("/$href", "/$href/*") ? $class = 'border-green-400 bg-green-100' : $class = '';
@endphp
<div class="w-full sm:w-1/3 sm:pb-0 pb-2 sm:px-4">
    <div class="border-2 border-gray-400 bg-gray-100 p-2 text-xl {{ $class }}">
        <a class="flex flex-nowrap justify-center" href="{{ $href }}" wire:navigate>
            <img class="mr-2" src="{{ secure_asset("svg/$svg.svg") }}" alt="">
            {{ $slot }}
        </a>
    </div>
</div>

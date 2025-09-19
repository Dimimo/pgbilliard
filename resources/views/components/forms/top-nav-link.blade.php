@php
    request()->is("/$href", "/$href/*") ? $class = 'border-green-400 bg-green-100' : $class = '';
@endphp

<div class="w-full pb-2 sm:w-1/3 sm:px-4 sm:pb-0">
    <div class="{{ $class }} border-2 border-gray-400 bg-gray-100 p-2 text-xl">
        <a class="flex flex-nowrap justify-center" href="{{ $href }}" wire:navigate>
            <img class="mr-2" src="{{ secure_asset("svg/$svg.svg") }}" alt="" />
            {{ $slot }}
        </a>
    </div>
</div>

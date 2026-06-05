@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'bg-white py-1'])

@php
    $alignmentClasses = match ($align) {
        'left' => 'left-0 origin-top-left',
        'top' => 'origin-top',
        default => 'right-0 origin-top-right',
    };

    if ($width === '48') {
        $width = 'w-48';
    }
@endphp

<div
    class="relative"
    x-data="{ open: false }"
    @click.outside="open = false"
    @close.stop="open = false"
>
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition:enter="transition duration-200 ease-out"
        x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition duration-75 ease-in"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-95 opacity-0"
        class="{{ $width }} {{ $alignmentClasses }} absolute z-50 mt-2 rounded-md shadow-lg"
        style="display: none"
        @click="open = false"
    >
        <div class="{{ $contentClasses }} rounded-md ring-1 ring-black ring-opacity-5">
            {{ $content }}
        </div>
    </div>
</div>

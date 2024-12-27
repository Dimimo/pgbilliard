@props(['title', 'subtitle' => null, 'help' => null])
<div class="grid grid-rows-auto gap-y-2 py-3 px-6 mb-2 md:mb-4 bg-blue-100 border-2 border-blue-300 rounded-lg" {{ $attributes }}>
    @if($help)
        <div class="flex flex-row">
            <div class="flex-none"></div>
            <div class="grow">
                <div class="text-center text-4xl text-blue-900">{!! $title !!}</div>
            </div>
            <div class="flex-none text-right">
                <button wire:click="$dispatch('openModal', { component: 'help.{{ $help }}' })">
                    <x-svg.circle-question-regular color="fill-green-600" size="6"/>
                </button>
            </div>
        </div>
    @else
        <div class="text-center text-4xl text-blue-900">{!! $title !!}</div>
    @endif
    @if(isset($subtitle))
        <div class="text-center text-xl text-cyan-800">{{ $subtitle }}</div>
    @endif
</div>

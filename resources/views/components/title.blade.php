<div class="grid grid-rows-auto gap-y-2 py-3 px-6 mb-4 bg-blue-100 border-2 border-blue-300 rounded-lg" {{ $attributes }}>
    <div class="text-center text-4xl text-blue-900">{!! $title !!}</div>
    @if(isset($subtitle))
        <div class="text-center text-xl text-cyan-800">{{ $subtitle }}</div>
    @endif
</div>

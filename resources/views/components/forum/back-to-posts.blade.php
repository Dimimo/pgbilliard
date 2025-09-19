<div class="mb-4 pb-3 pt-1 text-center">
    <a
        href="{{ route('forum.posts.index') }}"
        class="border-2 border-gray-300 bg-gray-100 p-2"
        wire:navigate
    >
        <x-svg.arrow-left-solid color="fill-black" size="4" padding="mb-1" />
        {{ __('back to the forum') }}
    </a>
</div>

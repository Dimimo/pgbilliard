<div class="mb-4 ml-4 pt-1">
    <a
        href="{{ route('forum.posts.create') }}"
        class="mx-auto border-2 border-yellow-500 bg-yellow-100 p-2"
        wire:navigate
    >
        <x-svg.square-plus-solid color="fill-green-600" size="5" padding="mb-1" />
        {{ __('Write a new post') }}
    </a>
</div>

@props(['post' => $post])

<div class="mb-4 pb-3 pt-1 text-center">
    <a
        href="{{ route('forum.posts.show', ['post' => $post]) }}"
        class="border-2 border-gray-300 bg-gray-100 p-2"
        wire:navigate
    >
        <x-svg.arrow-left-solid color="fill-black" size="4" padding="" />
        {{ __('back to post') }}
    </a>
</div>

@props(['post' => $post])

<div class="mb-4 text-center pt-1 pb-3">
    <a href="{{ route('forum.posts.show', ['post' => $post]) }}" class="p-2 bg-gray-100 border-2 border-gray-300" wire:navigate>
        <x-svg.arrow-left-solid color="fill-black" size="4" padding=""/>
        {{__('back to post')}}
    </a>
</div>

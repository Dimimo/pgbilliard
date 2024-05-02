@props(['post' => $post])

<div class="mb-4 text-center pt-1 pb-3">
    <a href="{{ route('forum.posts.show', ['post' => $post]) }}" class="p-2 bg-gray-100 border-2 border-gray-300" wire:navigate>
        <img class="mx-auto inline-block" src="{{ secure_asset('svg/back.svg') }}" alt="Back to post" width="22" height="22"> back to post
    </a>
</div>

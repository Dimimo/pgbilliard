@props(['post_id', 'showComment'])

<div class="ml-4 mb-4 pt-1">
    <button type="button"
            wire:click="$toggle('showComment')"
            class="p-2 mx-auto bg-yellow-100 border-2 border-yellow-500 cursor-pointer">
        <img class="mx-auto inline-block" src="{{ secure_asset('svg/comments.svg') }}" alt="Back to post" width="22" height="22">
        {{ $showComment ? 'Hide comment' : 'Add a comment'}}
    </button>
</div>

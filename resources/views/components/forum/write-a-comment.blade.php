@props(['post_id', 'showComment'])

<div class="ml-4 mb-4 pt-1">
    <button type="button"
            wire:click="$toggle('showComment')"
            class="p-2 mx-auto bg-yellow-100 border-2 border-yellow-500 cursor-pointer">
        <x-svg.message-regular color="fill-black" size="5" padding=""/>
        {{ $showComment ? 'Hide comment' : 'Add a comment'}}
    </button>
</div>

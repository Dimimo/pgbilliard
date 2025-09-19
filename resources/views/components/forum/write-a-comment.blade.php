@props(['post_id', 'showComment'])

<div class="mb-4 ml-4 pt-1">
    <button
        type="button"
        wire:click="$toggle('showComment')"
        class="mx-auto cursor-pointer border-2 border-yellow-500 bg-yellow-100 p-2"
    >
        <x-svg.message-regular color="fill-black" size="5" padding="" />
        {{ $showComment ? __('Hide comment') : __('Add a comment') }}
    </button>
</div>

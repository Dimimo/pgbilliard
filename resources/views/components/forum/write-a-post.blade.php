<div class="ml-4 mb-4 pt-1">
    <a href="{{ route('forum.posts.create') }}" class="p-2 mx-auto bg-yellow-100 border-2 border-yellow-500" wire:navigate>
        <x-svg.square-plus-solid color="fill-green-600" size="5" padding="mb-1"/>
        {{__('Write a new post')}}
    </a>
</div>

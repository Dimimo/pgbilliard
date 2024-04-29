<div>
    <div class="p-4 border-2 border-green-500 bg-green-100/25">
        {!! $post->body !!}
    </div>
    @can('update', $post)
        <div class="block my-2 float-right">
            <a href="/forum/posts/edit/{{ $post->id }}" wire:navigate>
                <x-forum.button-edit/>
            </a>
        </div>
    @endcan
</div>

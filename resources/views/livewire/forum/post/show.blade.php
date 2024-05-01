<div>
    <x-title
        id="comment-show"
        :title="$post->title"
        subtitle="Created by {{  $post->user->name }} on {{ $post->created_at->format('d-m-Y') }}"
    />

    <x-forum.back-to-posts/>

    <div class="border-2 border-green-500 bg-green-100/25">
        <div class="p-4 text-lg">{!! nl2br($post->body) !!}</div>
        @can('update', $post)
            <div class="bottom-0 px-1 text-right">
                <a href="/forum/posts/edit/{{ $post->id }}" wire:navigate>
                    <x-forum.button-edit/>
                </a>
            </div>
        @endcan
    </div>

    <livewire:forum.comments.index :post="$post"/>

</div>

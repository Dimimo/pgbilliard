<div>
    <x-title
        id="comment-show"
        :title="$post->title"
        subtitle="{{__('Created by')}} {{  $post->user->name }} {{__('on')}} {{ $post->created_at->format('d-m-Y') }}"
    />

    <x-forum.back-to-posts />

    <div class="rounded-lg border-2 border-gray-600 bg-white">
        <div class="p-4 text-lg">{!! nl2br($post->body) !!}</div>
        @can('update', $post)
            <div class="bottom-0 px-1 text-right">
                <a href="{{ route('forum.posts.edit', ['post' => $post]) }}" wire:navigate>
                    <x-forum.button-edit />
                </a>
            </div>
        @endcan
    </div>

    <livewire:forum.comments.index :post="$post" />
</div>

@php
    use App\Models\Forum\Comment;
@endphp

<div class="my-4">
    @can('create', Comment::class)
        <x-forum.write-a-comment :showComment="$showComment" />

        @if ($showComment)
            <livewire:forum.comments.create
                :comment="new \App\Models\Forum\Comment(['post_id' => $post->id])"
                :post="$post"
            />
        @endif
    @endcan

    @foreach ($comments as $comment)
        <div
            class="border-1 {{ $comment->updated_at->isCurrentMinute() ? 'bg-yellow-100' : 'bg-gray-50' }} my-2 ml-4 border border-gray-500"
        >
            <div class="mb-2 p-4">{!! nl2br($comment->body) !!}</div>
            <div
                class="flex justify-between border border-t-gray-500 bg-gray-200 px-2 pt-2 text-right text-sm"
            >
                <div>
                    {{ __('Posted by') }} {{ $comment->user->name }}
                    {{ $comment->updated_at->diffForHumans() }}
                </div>

                @can('update', $comment)
                    <div class="flex justify-end">
                        <div>
                            <a
                                href="{{ route('forum.comments.edit', ['comment' => $comment]) }}"
                                wire:navigate
                            >
                                <x-forum.button-edit />
                            </a>
                        </div>
                        <div
                            class="inline-block cursor-pointer px-1"
                            wire:click="delete({{ $comment->id }})"
                            wire:confirm="{{ __('Are you sure you want to delete your comment') }}?"
                        >
                            <x-forum.button-delete />
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    @endforeach
</div>

@php use App\Models\Forum\Comment; @endphp
<div class="my-4">
    @can('create', Comment::class)
        <x-forum.write-a-comment :showComment="$showComment"/>

        @if($showComment)
            <livewire:forum.comments.create :comment="new \App\Models\Forum\Comment(['post_id' => $post->id])" :post="$post"/>
        @endif

    @endcan

    @foreach($comments as $comment)
        <div class="my-2 ml-4 border border-1 border-gray-500  {{ $comment->updated_at->isCurrentMinute() ? 'bg-yellow-100' : 'bg-gray-50' }}">
            <div class="p-4 mb-2">{!! nl2br($comment->body) !!}</div>
            <div class="flex justify-between px-2 pt-2 text-sm text-right border border-t-gray-500 bg-gray-200">
                <div>
                    {{__('Posted by')}} {{ $comment->user->name }} {{ $comment->updated_at->diffForHumans() }}
                </div>

                @can('update', $comment)
                    <div class="flex justify-end">
                        <div>
                            <a href="{{ route('forum.comments.edit', ['comment' => $comment]) }}" wire:navigate>
                                <x-forum.button-edit/>
                            </a>
                        </div>
                        <div
                            class="inline-block px-1 cursor-pointer"
                            wire:click="delete({{ $comment->id }})"
                            wire:confirm="{{__('Are you sure you want to delete your comment')}}?"
                        >
                            <x-forum.button-delete/>
                        </div>
                    </div>
                @endcan

            </div>
        </div>
    @endforeach
</div>

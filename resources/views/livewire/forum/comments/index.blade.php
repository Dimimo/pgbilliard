<div class="my-4">
    @foreach($comments as $comment)
        <div class="border border-1 border-gray-500 bg-gray-50 my-2 p-4">{!! $comment->body !!}</div>
    @endforeach
</div>

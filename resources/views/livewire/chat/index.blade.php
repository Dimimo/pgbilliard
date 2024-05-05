<div>
    title: {{ $chatRoom->name }}<br>
    messages<br>
    <ul>
    @foreach($chatRoom->messages->sortByDesc('created_at') as $message)
        <li>{{ $message->created_at->appTimezone()->format('y-m-d H:m') }} ({{ $message->user->name }}): {{ $message->message }}</li>
    @endforeach
    </ul>

</div>

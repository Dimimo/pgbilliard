@props(['messages'])

<ul class="p-2 md:p-4 bg-gray-100 overflow-y-auto rounded-lg shadow-lg">
    @foreach($messages->sortByDesc('created_at') as $message)
    <li class="mb-4">
        <div class="flex items-center mb-2">
            <span class="text-gray-500 mr-2">{{ $message->created_at->appTimezone()->format('Y-m-d H:i') }}</span>
            <span class="font-semibold">{{ $message->user->name }}</span>
        </div>
        <p class="text-gray-800">{{ $message->message }}</p>
    </li>
    @endforeach
</ul>

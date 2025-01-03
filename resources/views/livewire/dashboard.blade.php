<div>
    <div class="mb-4 rounded-lg border-2 border-gray-500 p-4">
        <div class="mb-4 border-b border-gray-500 pl-4 text-xl">
            What is your role in the current Season?
        </div>
        @if ($team)
            <div>
                You play for <a
                    href="{{ route('teams.show', ['team' => $team]) }}"
                    class="inline-block text-blue-800 link"
                    wire:navigate
                >
                    {{ $team->name }}
                </a>
            </div>
            @if ($player->captain)
                <div>
                    You are a captain, you can <a
                        href="{{ route('teams.edit', ['team' => $team]) }}"

                        class="inline-block text-blue-800 link"
                        wire:navigate
                    >
                        manage your team here
                    </a>
                </div>
            @endif
            <div class="mt-4 text-lg">Your team members are:</div>
            @foreach($team->players->sortBy('name')->sortByDesc('captain') as $member)
                <div>{{ $member->user->name }} {{ $member->captain ? 'is captain' : '' }}</div>
            @endforeach
        @else
            <div>
                You don't play for a team. If you think this is an error, please
                <a href="{{ route('teams.index') }}" class="inline-block text-blue-800 link" wire:navigate>
                    contact your captain or bar owner
                </a>
            </div>
        @endif
    </div>

    <div class="mb-4 rounded-lg border-2 border-gray-500 p-4">
        <div class="mb-4 border-b border-gray-500 pl-4 text-xl">
            Forum posts that changed since last login
        </div>
        <ul>
            @forelse($this->newPosts() as $post)
                <li class="ml-4">
                    <a
                        href="{{ route('forum.posts.show', ['post' => $post]) }}"
                        class="inline-block text-blue-800 link"
                        wire:navigate
                    >
                        {{ $post->title }}
                    </a>
                    @if ($post->comments)
                        last comment by {{ $post->comments()->latest()->first()->user->name }}
                        {{ $post->comments()->latest()->first()->updated_at->diffForHumans() }}
                    @else
                        posted by {{ $post->user->name }} {{ $post->updated_at->diffForHumans() }}
                    @endif
                </li>
            @empty
                <li class="ml-4">No new posts or comments</li>
            @endforelse
        </ul>
    </div>

    <div class="mb-4 rounded-lg border-2 border-gray-500 p-4">
        <div class="mb-4 border-b border-gray-500 pl-4 text-xl">
            Chat rooms
        </div>
        <div>
            @foreach($rooms as $room)
                <div>
                    <a href="{{ route('chat.room', ['chatRoom' => $room]) }}"
                       class="inline-block text-blue-800 link"
                       wire:navigate
                    >
                        @if ($room->private)
                            <x-svg.key-solid color="fill-green-600" size="3" padding="mr-2"/>
                            <a href="{{ route('chat.room', ['chatRoom' => $room]) }}"
                               class="inline-block text-blue-800 link"
                               wire:navigate
                            >
                                {{ $room->name }}
                            </a>
                            created by {{ $room->owner->name }}
                        @else
                            <a href="{{ route('chat.room', ['chatRoom' => $room]) }}"
                               class="inline-block text-blue-800 link"
                               wire:navigate
                            >
                                {{ $room->name }}
                            </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

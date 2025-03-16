<div>
    <div class="mb-6">
        <x-navigation.main-links-buttons/>
    </div>

    <div class="mb-4 rounded-lg border-2 border-gray-500 p-2">
        <div class="mb-4 border-b border-gray-500 pl-4 text-xl">
            What is your role in the current Season {{ session('cycle') }}?
        </div>
        @if ($user->venue)
            <div class="my-4 rounded-lg bg-green-50 p-4">
                <div class="text-lg">A bar is on your name:</div>
                <div class="mb-4">
                    <a href="{{ route('venues.show', ['venue' => $user->venue]) }}"
                       class="inline-block text-blue-800 link"
                       wire:navigate
                    >
                        {{ $user->venue->name }}
                    </a>
                    <span class="text-sm">
                    (<a href="{{ route('venues.edit', ['venue' => $user->venue]) }}"
                        title="edit"
                        class="inline-block text-sm text-blue-800"
                        wire:navigate
                        >
                    edit
                </a>)
                </span>

                </div>
                <div class="text-lg">
                    There {{ trans_choice('plural.teams', $teams->count()) }} playing for {{ $user->venue->name }}:
                </div>
                @foreach($teams as $team)
                    <div class="flex flex-row items-center space-x-2">
                        <a
                            href="{{ route('teams.show', ['team' => $team]) }}"
                            class="inline-block text-blue-800 link"
                            wire:navigate
                        >
                            {{ $team->name }}
                        </a>
                        <div class="text-sm">
                            (<a href="{{ route('teams.edit', ['team' => $team]) }}"
                                title="edit"
                                class="inline-block text-sm text-blue-800"
                                wire:navigate
                            >
                                update team and players
                            </a>)
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="rounded-lg bg-indigo-50 p-4">
            @if ($team)
                <div class="mb-4 text-lg">Your participation:</div>
                <div class="mb-4">
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
                            You are the Captain, you can <a
                                href="{{ route('teams.edit', ['team' => $team]) }}"
                                class="inline-block text-blue-800 link"
                                wire:navigate
                            >
                                manage your team here
                            </a>
                        </div>
                    @endif
                </div>
                <div class="text-lg">Your team members are:</div>
            <ul class="list-inside list-disc">
                @foreach($team->players->sortBy('name')->sortByDesc('captain') as $member)
                    <li>{{ $member->user->name }} {{ $member->captain ? 'is captain' : '' }}</li>
                @endforeach
            </ul>

            @else
                <div class="mb-4">
                    You don't play for a team. If you think this is an error, please
                    <a href="{{ route('teams.index') }}" class="inline-block text-blue-800 link" wire:navigate>
                        contact your captain or bar owner
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="mb-4 rounded-lg border-2 border-gray-500 p-2">
        <div class="mb-4 border-b border-gray-500 pl-4 text-xl">
            Forum posts that changed since your last login
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

    <div class="mb-4 rounded-lg border-2 border-gray-500 p-2">
        <div class="mb-4 border-b border-gray-500 pl-4 text-xl">
            Chat rooms
        </div>
        <div class="px-4">
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

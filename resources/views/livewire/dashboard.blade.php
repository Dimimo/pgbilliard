<div>
    <div class="mb-6">
        <x-navigation.main-links-buttons/>
    </div>

    <div class="mb-4 rounded-lg border-2 border-gray-500 p-2">
        <div class="mb-4 border-b border-gray-500 pl-4 text-xl">
            {{__('What is your role in the current Season')}} {{ session('cycle') }}?
        </div>
        @if ($user->venue)
            <div class="my-4 rounded-lg bg-green-50 p-4">
                <div class="text-lg">{{__('A bar is on your name')}}:</div>
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
                    {{__('Edit')}}
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
                            {{__('update team and players')}}
                            </a>)
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="rounded-lg bg-indigo-50 p-4">
            @if ($team)
                <div class="mb-4 text-lg">{{__('Your participation')}}:</div>
                <div class="mb-4">
                    <div>
                        {{__('You play for')}} <a
                            href="{{ route('teams.show', ['team' => $team]) }}"
                            class="inline-block text-blue-800 link"
                            wire:navigate
                        >
                            {{ $team->name }}
                        </a>
                    </div>
                    <div class="my-4">
                        {{__('Your current')}} <a
                            href="{{ route('rank') }}"
                            class="inline-block text-blue-800 link"
                            wire:navigate
                        >{{__('individual rank is')}}</a>
                        <span class="m-1 rounded-full border border-green-500 bg-green-100 px-2 py-1 font-bold">
                            {{ $rank }}
                        </span>
                    </div>
                    @if ($player->captain)
                        <div>
                            {{__('You are the Captain, you can')}} <a
                                href="{{ route('teams.edit', ['team' => $team]) }}"
                                class="inline-block text-blue-800 link"
                                wire:navigate
                            >
                            {{__('manage your team here')}}
                            </a>
                        </div>
                    @endif
                </div>
                <div class="text-lg">{{__('Your team members are')}}:</div>
                <ul class="list-inside list-disc">
                    @foreach($team->players->sortBy('name')->sortByDesc('captain') as $member)
                        <li>{{ $member->user->name }} {{ $member->captain ? 'is captain' : '' }}</li>
                    @endforeach
                </ul>

            @else
                <div class="mb-4">
                    {{__("You don't play for a team. If you think this is an error")}}
                    <a href="{{ route('teams.index') }}" class="inline-block text-blue-800 link" wire:navigate>
                        {{__('contact your captain or bar owner')}}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="mb-4 rounded-lg border-2 border-gray-500 p-2">
        <div class="mb-4 border-b border-gray-500 pl-4 text-xl">
            {{__('Forum posts that changed since your last login')}}
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
                    @if ($post->comments && $comment = $post->comments()->latest()->first())
                    {{__('last comment by')}} {{ $comment->user->name }}
                        {{ $comment->updated_at->diffForHumans() }}
                    @else
                    {{__('posted by')}} {{ $post->user->name }} {{ $post->updated_at->diffForHumans() }}
                    @endif
                </li>
            @empty
                <li class="ml-4">{{__('No new posts or comments')}}</li>
            @endforelse
        </ul>
    </div>

    <div class="mb-4 rounded-lg border-2 border-gray-500 p-2">
        <div class="mb-4 border-b border-gray-500 pl-4 text-xl">
            {{__('Chat rooms')}}
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
                        {{__('created by')}} {{ $room->owner->name }}
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

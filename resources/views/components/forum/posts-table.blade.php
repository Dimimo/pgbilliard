@props(['posts'])
<div id="top-posts" class="overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead class="whitespace-nowrap bg-gray-800">
        <tr>
            <th></th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-white"></th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-white">Started by</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-white">Last update</th>
            <th></th>
            @if(session('is_admin'))
                <th class="px-6 py-3 text-left text-sm font-semibold text-white">Sticky?</th>
            @endif
            <th class="px-6 py-3 text-left text-sm font-semibold text-white">Locked?</th>
            @auth()
                <th class="px-6 py-3 text-left text-sm font-semibold text-white">Actions</th>
            @endauth
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach($posts as $post)
            <tr class="h-8 hover:bg-blue-50" wire:key="{{ $post->id }}">
                <td>
                    @if ($post->visits->count() === 1)
                        <div class="ml-4" title="Has been opened">
                            <x-svg.envelope-solid color="fill-green-700" size="5"/>
                        </div>
                    @else
                        <div class="ml-4" title="Not opened yet">
                            <x-svg.envelope-open-text-solid color="fill-black" size="5"/>
                        </div>
                    @endif
                </td>
                <td @class(['font-bold' => $post->is_sticky])>
                    <a class="ml-4 whitespace-nowrap" href="{{ route('forum.posts.show', ['post' => $post]) }}" wire:navigate>
                        {{ $post->title }}
                    </a>
                </td>
                <td>
                    <div class="ml-4 text-sm">
                        {{ $post->user->name }}
                    </div>
                </td>
                <td>
                    <div class="ml-4 text-sm">
                        {{ $post->updated_at->diffForHumans(['parts' => 1, 'short' => false]) }}
                    </div>
                </td>
                <td>
                    @if($post->comments_count > 0)
                        <x-svg.comments-solid color="fill-black" size="5"/> {{ $post->comments_count }}
                    @endif
                </td>
                @if(session('is_admin'))
                    <td>
                        <label class="flex justify-center">
                            <input type="checkbox" @if($post->is_sticky) checked @endif wire:click="toggle_sticky({{ $post->id }})"/>
                        </label>
                    </td>
                    <td>
                        <label class="flex justify-center">
                            <input type="checkbox" @if($post->is_locked) checked @endif wire:click="toggle_locked({{ $post->id }})"/>
                        </label>
                    </td>
                @else
                    <td>
                        @if($post->is_locked)
                            <div class="flex justify-center" title="Post is locked">
                                <x-svg.lock-solid color="fill-gray-500" size="5"/>
                            </div>
                        @endif
                    </td>
                @endif
                @auth()
                    <td class="px-6 py-3">
                        @can('update', $post)
                            <a class="px-1" href="{{ route('forum.posts.edit', ['post' => $post]) }}" wire:navigate>
                                <x-forum.button-edit/>
                            </a>
                        @endcan
                        @can('delete', $post)
                            <div
                                class="inline-block cursor-pointer px-1"
                                wire:click="delete({{ $post->id }})"
                                wire:confirm="Are you sure you want to delete the post?"
                            >
                                <x-forum.button-delete/>
                            </div>
                        @endcan
                    </td>
                @endauth
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $posts->links(data: ['scrollTo' => '#top-posts']) }}

</div>

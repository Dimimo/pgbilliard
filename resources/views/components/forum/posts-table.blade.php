<div id="top-posts" class="overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead class="bg-gray-800 whitespace-nowrap">
        <tr>
            <th></th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-white"></th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-white">Started by</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-white">Last update</th>
            <th></th>
            @if(Auth::check() && Auth::user()->isAdmin())
                <th class="px-6 py-3 text-left text-sm font-semibold text-white">Sticky?</th>
            @endif
            <th class="px-6 py-3 text-left text-sm font-semibold text-white">Locked?</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-white">Actions</th>
        </tr>
        </thead>
        <tbody class="whitespace-nowrap">
        @foreach($posts as $post)
            <tr class="hover:bg-blue-50" wire:key="{{ $post->id }}">
                <td class="px-6 py-3 text-sm">
                    @if ($post->visits->count() === 1)
                        <img class="inline-block" src="{{ secure_asset('svg/envelop-open.svg') }}" alt="Post is read" width="22" height="22">
                    @else
                        <img class="inline-block" src="{{ secure_asset('svg/envelop-closed.svg') }}" alt="New post" width="22" height="22">
                    @endif
                </td>
                <td class="pl-6 py-3 @if($post->is_sticky)font-bold @endif">
                    <a class="block" href="/forum/posts/show/{{ $post->id }}" wire:navigate>
                        {{ $post->title }}
                    </a>
                </td>
                <td class="px-6 py-3 text-sm">
                    {{ $post->user->name }}
                </td>
                <td class="px-6 py-3 text-sm">
                    {{ $post->updated_at->diffForHumans(['parts' => 2, 'join' => true, 'short' => true]) }}
                </td>
                <td class="px-6 py-3 text-sm">
                    @if($post->comments_count > 0)
                        <img class="mx-auto inline-block" src="{{ secure_asset('svg/comments.svg') }}" alt="Comments" width="22"
                             height="22"> {{ $post->comments_count }}
                    @endif
                </td>
                @if(Auth::check() && Auth::user()->isAdmin())
                    <td class="px-6 py-3 text-center">
                        <label>
                            <input type="checkbox" @if($post->is_sticky) checked @endif wire:click="toggle_sticky({{ $post->id }})"/>
                        </label>
                    </td>
                    <td class="px-6 py-3 text-center">
                        <label>
                            <input type="checkbox" @if($post->is_locked) checked @endif wire:click="toggle_locked({{ $post->id }})"/>
                        </label>
                    </td>
                @else
                    <td class="px-6 py-3 text-center">
                        @if($post->is_locked)
                            <img class="mx-auto inline-block" src="{{ secure_asset('svg/lock.svg') }}" alt="Post is locked" width="22" height="22">
                        @endif
                    </td>
                @endif
                <td class="px-6 py-3">
                    @can('update', $post)
                        <a class="px-1" href="/forum/posts/edit/{{ $post->id }}" wire:navigate>
                            <x-forum.button-edit/>
                        </a>
                    @endcan
                    @can('delete', $post)
                        <div
                            class="inline-block px-1 cursor-pointer"
                            wire:click="delete({{ $post->id }})"
                            wire:confirm="Are you sure you want to delete the post?"
                        >
                            <x-forum.button-delete/>
                        </div>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $posts->links(data: ['scrollTo' => '#top-posts']) }}

</div>

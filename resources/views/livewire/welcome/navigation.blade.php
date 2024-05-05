<div class="p-1 text-right z-10">
    @auth
        <a href="{{ route('dashboard') }}"
           class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
           wire:navigate>Dashboard</a>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.index') }}"
               class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Administration</a>
        @endif
        <a href="{{ route('chat.index') }}"
           class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
           wire:navigate>Chat</a>
    @else
        <a href="{{ route('login') }}"
           class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Log in</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}"
               class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Register</a>
        @endif
        <a href="{{ route('players.accounts') }}"
           class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Claim
            existing account</a>
    @endauth
        <a href="{{ route('scoresheet') }}"
           class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
           wire:navigate>Scoresheet</a>
    <a href="{{ route('forum.posts.index') }}"
       class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
       wire:navigate>Forum</a>
</div>

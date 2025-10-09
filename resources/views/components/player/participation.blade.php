@props(['team', 'player', 'rank'])
@php
    $your = request()->routeIs('dashboard') ? 'Your' : "";
@endphp

<div class="rounded-lg bg-indigo-50 p-4">
    @if ($team)
        @if (request()->routeIs('dashboard'))
            <div class="mb-4 text-xl">
                {{ Str::replace('Your', $your, __('Your participation')) }}:
            </div>
        @endif

        <div class="my-4 text-lg">
            <a href="{{ route('rank') }}" class="link inline-block text-blue-800" wire:navigate>
                {{ Str::replace('Your', $your, __('Your current individual rank is')) }}
            </a>
            <span
                class="m-1 rounded-full border border-green-500 bg-green-100 px-2 py-0.5 font-bold"
            >
                {{ $rank }}
            </span>
        </div>
        <div class="mb-4">
            <div>
                {{ Str::replace('Your', $your, __('Your Team')) }}:
                <a
                    href="{{ route('teams.show', ['team' => $team]) }}"
                    class="link inline-block text-blue-800"
                    wire:navigate
                >
                    {{ $team->name }}
                </a>
            </div>
            @if (request()->routeIs('dashboard') && $player->captain)
                <div>
                    {{ __('You are the Captain, you can') }}
                    <a
                        href="{{ route('teams.edit', ['team' => $team]) }}"
                        class="link inline-block text-blue-800"
                        wire:navigate
                    >
                        {{ __('manage your team here') }}
                    </a>
                </div>
            @endif
        </div>
        <div class="mb-2 text-lg">
            {{ Str::replace('Your', $your, __('Your team members are')) }}:
        </div>
        <ul class="list-inside list-disc">
            @foreach ($team->players->where('active', true)->sortBy('name')->sortByDesc('captain') as $member)
                <li class="list-item">
                    <span class="inline-block">
                        <a
                            class="link text-blue-800"
                            href="{{ route('players.show', ['player' => $member->id]) }}"
                            wire:navigate
                        >
                            {{ $member->user->name }}
                        </a>
                    </span>
                    <span>
                        {{ $member->captain ? __('is Captain') : '' }}
                    </span>
                </li>
            @endforeach
        </ul>
    @elseif (request()->routeIs('dashboard'))
        <div class="mb-4">
            {{ __("You don't play for a team. If you think this is an error") }}
            <a
                href="{{ route('teams.index') }}"
                class="link inline-block text-blue-800"
                wire:navigate
            >
                {{ __('contact your captain or bar owner') }}
            </a>
        </div>
    @endif
</div>

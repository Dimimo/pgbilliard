<div class="mt-4">
    @forelse ($players as $player)
        <div class="flex justify-center" wire:key="{{ $player->id }}">
            <div class="p-2">
                <x-team.captain :player="$player" />
            </div>
            <div class="p-2 text-xl">{{ $player->name }}</div>
            <div class="p-2">
                @auth()
                    @if ($player->phone)
                        <x-svg.mobile-screen-solid color="fill-green-600" size="5" />
                        {{ $player->phone }}
                    @endif
                @endauth
            </div>
        </div>
    @empty
        <div class="flex justify-center text-xl">{{ __('No selected players in this team') }}</div>
    @endforelse

    @if (!request()->is('teams/show/*'))
        <a
            href="{{ route('teams.show', ['team' => $team]) }}"
            class="flex justify-end px-4 pt-4 text-blue-700"
            wire:navigate
        >
            {{ __('Team details') }}
        </a>
    @endif

    @can('update', $team)
        <div class="mb-1 mr-4 flex justify-end">
            <a
                href="{{ route('teams.edit', ['team' => $team]) }}"
                class="link inline-block text-blue-700"
                wire:navigate
            >
                <x-svg.pen-to-square-solid color="fill-blue-700" size="4" padding="mr-2 mb-1" />
                {{ __('Edit the team players') }}
            </a>
        </div>
    @endcan
</div>

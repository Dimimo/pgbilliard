<div>
    <x-forms.sub-title title="{{__('The players')}}">
        <div class="mt-4">
            <div class="my-2 flex justify-center">
                <div
                    @class([
                    'max-w-min whitespace-nowrap rounded-lg border-2',
                    'border-teal-400 bg-teal-100' => !$max_reached,
                    'border-indigo-400 bg-indigo-50' => $max_reached,
                    'px-4 py-2 text-center text-xl',
                    ])
                >
                    {{ $players->count() }} {{ __('players selected of a maximum of') }}
                    {{ $max_players }}
                </div>
            </div>

            @forelse ($players as $player)
                <div
                    class="flex flex-row p-1"
                    wire:key="player-{{ $player->id }}"
                    x-data="{ edit: false }"
                >
                    <div class="mx-4 basis-1/12 text-right">
                        <button
                            wire:click="toggleCaptain({{ $player->id }})"
                            class="cursor-pointer"
                            title="{{
                                $player->captain
                                ? __('Toggle to make a regular player')
                                : __('Toggle to make a captain')
                            }}"
                            wire:confirm="{{ __('Change the captain status of') }} {{ $player->user_id === auth()->id() ? 'YOURSELF' : $player->name }}?"
                        >
                            <x-team.captain :player="$player" />
                        </button>
                    </div>

                    <div class="basis-5/12 text-xl font-semibold" x-show="!edit">
                        {{ $player->name }}
                    </div>
                    <div class="basis-4/12 text-xl" x-show="!edit">
                        {{ $player->phone }}
                    </div>
                    <div class="basis-9/12" x-cloak x-show="edit">
                        <form wire:submit="editUserUpdate">
                            <x-player.admin-player-inline-change :player="$player" />
                        </form>
                    </div>
                    <div class="mr-2 basis-2/12 text-right">
                        @if (session('is_admin') && $show_new_player_form)
                            <button
                                class="cursor-pointer"
                                title="{{ __('Edit this player') }}"
                                x-on:click="edit = !edit"
                                wire:click="editUser({{ $player->user_id }})"
                            >
                                <x-svg.pen-to-square-solid
                                    color="fill-green-600"
                                    size="5"
                                    padding="mb-1 mr-2"
                                />
                            </button>
                        @endif

                        <button
                            class="cursor-pointer"
                            title="{{ __('Remove this player') }}"
                            wire:confirm="{{ __('Are you sure you want to remove this player from the team?') }}"
                            wire:click="removePlayer({{ $player->id }})"
                        >
                            <x-svg.user-minus-solid color="fill-red-500" size="7" />
                        </button>
                    </div>
                </div>
            @empty
                <div class="my-4 text-center text-xl text-red-700">
                    {{ __('There are no players added to the team yet!') }}
                </div>
            @endforelse

            <x-player.list-team-players-hints />
        </div>
    </x-forms.sub-title>

    @if (!$max_reached && $show_new_player_form)
        <x-forms.sub-title title="{{__('Add a player to the team')}}">
            <x-player.list-team-available-players-dropdown
                :available_players="$available_players"
            />

            <form class="m-4 w-auto border-2 border-green-500 p-2" wire:submit="addUser">
                <x-player.list-team-add-new-user />
            </form>
        </x-forms.sub-title>
    @elseif ($show_new_player_form)
        <div class="text-lg text-red-700">
            {{ __('The maximum allowed players has been reached!') }}
        </div>
    @endif
</div>

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
                    {{ $players->count() }} {{__('players selected of a maximum of')}} {{ $max_players }}
                </div>
            </div>

            @forelse($players as $player)
                <div
                    class="flex flex-row p-1"
                    wire:key="player-{{ $player->id }}"
                    x-data="{ edit: false }"
                >
                    <div class="mx-4 basis-1/12 text-right">
                        <button
                            wire:click="toggleCaptain({{ $player->id }})"
                            class="cursor-pointer"
                            title="{{$player->captain
                                ? __('Toggle to make a regular player')
                                : __('Toggle to make a captain')}}"
                            wire:confirm="{{__('Change the captain status of')}} {{ $player->user_id === auth()->id() ? 'YOURSELF' : $player->name }}?"
                        >
                            <x-team.captain :player="$player"/>
                        </button>

                    </div>

                    <div class="basis-5/12 text-xl font-semibold" x-show="!edit">
                        {{ $player->name }}
                    </div>
                    <div class="basis-4/12 text-xl" x-show="!edit">
                        {{ $player->phone }}
                    </div>
                    <div class="basis-9/12" x-cloak x-show="edit">
                        <form class="flex flex-row flex-nowrap items-center space-x-2" wire:submit="editUserUpdate">
                            <label for="user_edit.name_{{ $player->id }}"></label>
                            <input id="user_edit.name_{{ $player->id }}" type="text" wire:model="user_form.name">

                            <label for="user_edit.contact_nr_{{ $player->id }}"></label>
                            <input id="user_edit.contact_nr_{{ $player->id }}" type="text" wire:model="user_form.contact_nr">

                            <x-forms.secondary-button type="submit" x-on:click="edit = !edit">
                                Update
                            </x-forms.secondary-button>
                            <x-forms.spinner/>
                        </form>
                    </div>
                    <div class="mr-2 basis-2/12 text-right">
                        @if(session('is_admin') && $show_new_player_form)
                            <button
                                class="cursor-pointer"
                                title="Edit this player"
                                x-on:click="edit = !edit"
                                wire:click="editUser({{ $player->user_id }})"
                            >
                                <x-svg.pen-to-square-solid color="fill-green-600" size="5" padding="mb-1 mr-2"/>
                            </button>

                        @endif
                        <button
                            class="cursor-pointer"
                            title="Remove this user"
                            wire:confirm="{{__('Are you sure you want to remove this player from the team?')}}"
                            wire:click="removePlayer({{ $player->id }})"
                        >
                            <x-svg.user-minus-solid color="fill-red-500" size="7"/>
                        </button>
                    </div>
                </div>
            @empty
                <div class="my-4 text-center text-xl text-red-700">
                    {{__('There are no players added to the team yet!')}}
                </div>
            @endforelse

            <div class="m-2 block border border-green-400 bg-green-100 p-4 text-center text-lg">
                <p>
                    <span class="font-semibold underline">Hint</span>: click on
                    <x-svg.circle-user-solid color="fill-green-600" size="5"/>
                    or
                    <x-svg.user-tie-solid color="fill-orange-500" size="5"/>
                    to toggle the captain option.
                </p>
                <p>
                    Click on
                    <x-svg.user-minus-solid color="fill-red-500" size="5"/>
                    will remove the player. A warning is given, but it's easy to reassign any player.
                </p>
                <p>If the captain has no phone number, the contact number of the venue's owner is shown.</p>
                <p><span class="font-semibold">Every player</span> is responsible for their own data.</p>
            </div>
        </div>

    </x-forms.sub-title>

    @if (!$max_reached && $show_new_player_form)
        <x-forms.sub-title title="{{__('Add a player to the team')}}">
            <div class="flex items-center justify-center">
                <div class="mt-1 p-2 text-xl">
                    <label for="user_id">
                        {{__('Select a player from the users table')}}
                    </label>
                </div>
                <div class="p-2">
                    <select id="user_id" wire:model.change="user_id">
                        <option> -- select --</option>
                        @foreach(array_diff($users, $occupied_players) as $id => $name)
                            <option
                                wire:key="add-{{ $id }}"
                                value="{{ $id }}"
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-32">
                    <x-forms.action-message class="mx-3" on="users-list-updated" class="text-xl">
                        {{ count(array_diff($users, $occupied_players)) }} {{__('users')}}
                    </x-forms.action-message>
                </div>
            </div>

            <div class="flex justify-center p-2 text-sm italic text-gray-500">
                If the player you are looking for is not in the list, (s)he is probably assigned to another team or is new.
            </div>

            <div class="flex items-center justify-center">
                <div class="mt-1 p-2 text-xl">
                    <label for="carbon_sub">Select only players who were active after</label>
                </div>
                <div class="p-2">
                    <select id="carbon_sub" wire:model.change="carbon_sub">
                        <option value="20 years">No limit</option>
                        <option value="6 months">6 months ago</option>
                        <option value="1 year">1 year ago</option>
                        <option value="2 years">2 years ago</option>
                        <option value="3 years">3 years ago</option>
                    </select>
                </div>
                <div class="w-32"></div>
            </div>

            <form class="m-4 w-auto border-2 border-green-500 p-2" wire:submit="addUser">
                <div class="flex flex-col items-center">
                    <div class="mt-1 p-2">
                        <div class="text-center text-xl">
                            {{__('Or add a new player')}}
                        </div>
                    </div>
                    <div class="flex items-center p-2">
                        <label class="mr-2" for="user_form.name">{{__('Name')}}</label>
                        <input id="user_form.name" type="text" wire:model.live.debounce.500ms="user_form.name">
                        <span class="w-10 flex-none"><x-forms.spinner target="user_form.name"/></span>
                    </div>
                    <div class="pb-2">
                        @error('user_form.name') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex items-center p-2">
                        <label class="mr-2" for="user_form.email">Email</label>
                        <input id="user_form.email" type="text" wire:model.blur="user_form.email">
                        <span class="w-10 flex-none"><x-forms.spinner target="user_form.email"/></span>
                    </div>
                    <div>
                        @error('user_form.email') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                    <div class="text-sm italic text-gray-500">
                        {{__("If you don't have the person's email, it is auto generated")}}.
                    </div>
                    <div class="p-2">
                        <div class="flex items-center py-2">
                            <label class="mr-2" for="user_form.contact_nr">Contact</label>
                            <input id="user_form.contact_nr" type="text" wire:model="user_form.contact_nr">
                            <span class="w-10 flex-none"></span>
                        </div>

                        <div class="text-sm italic text-gray-500">
                            {{__("You can leave this empty if you don't have the number")}}
                        </div>
                        <div>
                            @error('form.contact_nr') <span class="text-red-700">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="p-2">
                        <x-forms.primary-button>Create</x-forms.primary-button>
                    </div>
                    @if ($errors->any())
                        <div class="p-2 text-red-700">
                            <ul class="list-disc">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <x-forms.spinner target="addUser"/>
                    <x-forms.action-message class="p-2" on="user-created" class="text-xl">
                        {{__('User created and added to your team! A reminder has been sent with the login info.')}}
                    </x-forms.action-message>
                </div>
            </form>
        </x-forms.sub-title>
    @elseif ($show_new_player_form)
        <div class="text-lg text-red-700">
            {{__('The maximum allowed players has been reached!')}}
        </div>
    @endif
</div>

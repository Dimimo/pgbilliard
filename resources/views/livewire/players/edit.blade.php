<div>
    <x-forms.sub-title title="The players">
        <div class="mt-4">
            @forelse($players as $player)
                <div class="flex flex-row p-1" wire:key="{{ $player->id }}">
                    <div class="basis-1/12 ml-4">
                        <x-team.captain :player="$player"
                                   wire:click="toggleCaptain({{ $player->id }})"
                                   class=" cursor-pointer"
                                   :title="$player->captain ? 'Toggle to make a regular player' : 'Toggle to make a captain'"
                        />
                    </div>

                    <div class="basis-5/12 text-xl font-semibold">{{ $player->name }}</div>
                    <div class="basis-5/12 text-xl">{{ $player->contact_nr }}</div>

                    {{--<div class="flex-none px-2">
                        <img class="float-right" src="{{ secure_asset('svg/pen-square.svg') }}" alt="" width="24" height="24">
                    </div>--}}

                    <div class="basis-1/12">
                        <img
                            class="cursor-pointer" src="{{ secure_asset('svg/user-delete.svg') }}"
                            title="Remove this user"
                            alt=""
                            width="24"
                            height="24"
                            wire:confirm="Are you sure you want to remove this player from the team?"
                            wire:click="removePlayer({{ $player->id }})"
                        >
                    </div>
                </div>
            @empty
                <div class="text-xl text-center text-red-700 my-4">There are no players added to the team yet!</div>
            @endforelse

            <div class="block border border-green-400 bg-green-100 m-2 text-center text-lg p-4">
                <p>
                    <span class="underline font-semibold">Hint</span>: click on
                    <img class="inline-block" alt="" src="{{ secure_asset('svg/user-circle.svg') }}" width="24px" height="24px">
                    or <img class="inline-block" alt="" src="{{ secure_asset('svg/user-tie.svg') }}" width="24px" height="24px">
                    to toggle the captain option.
                </p>
                <p>
                    Click on <img
                        class="inline-block" src="{{ secure_asset('svg/user-delete.svg') }}"
                        title="Remove this user"
                        alt=""
                        width="24"
                        height="24"/> will remove the player. A warning is given, but it's easy to reassign any player.
                </p>
                <p>If the captain has no phone number, the contact number of the venue's owner is shown.</p>
                <p><span class="font-semibold">Every player</span> is responsible for their own data.</p>
            </div>
        </div>

    </x-forms.sub-title>

    <x-forms.sub-title title="Add a player to the team">
        <div class="flex justify-center items-center">
            <div class="p-2 mt-1 text-xl">
                <label for="user_id">Select a player from the users table</label>
            </div>
            <div class="p-2">
                <select id="user_id" wire:model.change="user_id">
                    <option> -- select --</option>
                    @foreach(array_diff($users, $occupied_players) as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-32">
                <x-forms.action-message class="mx-3" on="users-list-updated" class="text-xl">
                    {{ count(array_diff($users, $occupied_players)) }} users
                </x-forms.action-message>
            </div>
        </div>

        <div class="flex justify-center p-2 text-sm text-gray-500 italic">
            If the player you are looking for is not in the list, (s)he is probably assigned to another team or is new.
        </div>

        <div class="flex justify-center items-center">
            <div class="p-2 mt-1 text-xl">
                <label for="user_id">Select only players who were active after</label>
            </div>
            <div class="p-2">
                <select id="user_id" wire:model.change="carbon_sub">
                    <option value="20 years">No limit</option>
                    <option value="6 months">6 months ago</option>
                    <option value="1 year">1 year ago</option>
                    <option value="2 years">2 years ago</option>
                    <option value="3 years">3 years ago</option>
                </select>
            </div>
            <div class="w-32"></div>
        </div>

        <form class="border-2 border-green-500 p-2 m-4 w-auto" wire:submit="addUser">
            <div class="flex flex-col items-center">
                <div class="p-2 mt-1">
                    <div class="text-center text-xl">Or add a new player</div>
                    <div class="text-red-700 text-center text-sm">(Make sure the player's name doesn't already exist!)</div>
                </div>
                <div class="flex items-center p-2">
                    <label class="mr-2" for="user_form.name">Name</label>
                    <input id="user_form.name" type="text" wire:model.live.debounce.500ms="user_form.name">
                    <span class="flex-none w-10"><x-forms.spinner target="user_form.name"/></span>
                </div>
                <div class="pb-2">
                    @error('user_form.name') <span class="text-red-700">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-center p-2">
                    <label class="mr-2" for="user_form.email">Email</label>
                    <input id="user_form.email" type="text" wire:model="user_form.email">
                    <span class="flex-none w-10"></span>
                    <div>
                        @error('user_form.email') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="text-sm text-gray-500 italic">
                    If you don't have the person's email, it is auto generated, the password is '<strong>secret</strong>'
                </div>
                <div class="p-2">
                    <div class="flex items-center py-2">
                        <label class="mr-2" for="user_form.contact_nr">Contact</label>
                        <input id="user_form.contact_nr" type="text" wire:model="user_form.contact_nr">
                        <span class="flex-none w-10"></span>
                    </div>

                    <div class="text-sm text-gray-500 italic">You can leave this empty if you don't have the number</div>
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
                    User created!
                </x-forms.action-message>
            </div>
        </form>
    </x-forms.sub-title>
</div>

<div>
    <x-sub-title title="The players">
        @foreach($players as $player)
            <div class="grid grid-cols-8 w-full gap-4 p-4" wire:key="{{ $player->id }}">
                <x-captain :player="$player"
                           wire:click="toggleCaptain({{ $player->id }})"
                           class=" cursor-pointer"
                />
                <div>
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
                <div class="col-span-3 text-xl">
                    {{ $player->name }}
                </div>
                <div class="col-span-3 text-xl">{{ $player->contact_nr }}</div>
            </div>
        @endforeach
    </x-sub-title>

    <x-sub-title title="Add a player to the team">
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
                <x-action-message class="mx-3" on="users-list-updated" class="text-xl">
                    {{ count(array_diff($users, $occupied_players)) }} users
                </x-action-message>
            </div>
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
                <div class="p-2 mt-1 text-xl">
                    Or add a user
                </div>
                <div class="p-2">
                    <label class="mr-2" for="user_form.name">Name</label>
                    <input id="user_form.name" type="text" wire:model.live="user_form.name">
                    <div>
                        @error('user_form.name') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>

                </div>
                <div class="p-2">
                    <label class="mr-2" for="user_form.contact_nr">Contact number</label>
                    <input id="user_form.contact_nr" type="text" wire:model="user_form.contact_nr">
                    <div>
                        @error('form.contact_nr') <span class="text-red-700">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="p-2">
                    <x-primary-button>Create</x-primary-button>
                    @error('user_form.email')
                        {{ $message }}
                    @enderror
                    @error('user_form.contact_nr')
                    {{ $message }}
                    @enderror
                    @error('user_form.password')
                    {{ $message }}
                    @enderror
                    @error('user_form.gender')
                    {{ $message }}
                    @enderror
                </div>
                <x-spinner target="addUser" />
                <x-action-message class="p-2" on="user-created" class="text-xl">
                    User created!
                </x-action-message>
            </div>
        </form>
    </x-sub-title>
</div>

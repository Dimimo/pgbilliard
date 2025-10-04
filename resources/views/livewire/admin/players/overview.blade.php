<div class="flex flex-col">
    <div class="border-green-5000 mb-8 rounded-xl border bg-green-50 p-4">
        <div class="mb-4 font-bold">
            You have to be a little bit careful here. Any user you delete can not be undone. There
            is a failsafe.
        </div>
        <ul class="mb-4 list-inside list-disc">
            <li class="list-item">
                <span class="font-bold">Administrators</span>
                can not be deleted
            </li>
            <li class="list-item">
                Users (players) with registered individual games can not be deleted
            </li>
        </ul>
        <div class="mb-4">
            The table is best viewed on
            <span class="font-bold">bigger screens</span>
            . The columns are as following:
        </div>
        <ul class="mb-4 list-inside list-disc">
            <li class="list-item">
                Select the
                <span class="font-bold">limit</span>
                to filter out recently active users
            </li>
            <li class="list-item">
                Click on
                <x-svg.sort-solid color="fill-green-700" />
                to
                <span class="font-bold">sort columns</span>
                ; click on the same column twice to reverse the order
            </li>
            <li class="list-item">
                The fist column is
                <span class="font-bold">the id</span>
                in the table. The higher the number, the more recent the user has been registered
            </li>
            <li class="list-item">
                <span class="font-bold">Contact Nr</span>
                and
                <span class="font-bold">Played For</span>
                are for your information only
            </li>
            <li class="list-item">
                <x-svg.circle-user-solid color="fill-green-700" />
                shows the amount of
                <span class="italic">players</span>
                each user has. Every Season creates a new player. Changing teams creates a new
                player as well. It gives an indication of how long the player has participated in
                the League
            </li>
            <li class="list-item">
                <span class="font-bold">Games</span>
                is the amount of registered individual games the player has. Singles and doubles
            </li>
        </ul>
        <div class="mb-4">
            Users with
            <x-svg.user-check-solid class="cursor-not-allowed" color="fill-green-700" size="6" />
            can not be deleted. It means they have individual games.
        </div>
        <div class="mb-4">
            Users with
            <x-svg.user-minus-solid class="cursor-pointer" color="fill-red-700" size="6" />
            can be deleted. A
            <span class="font-bold">confirmation popup</span>
            shows up.
        </div>
        <div>
            <span class="font-bold">Suggestion:</span>
            start to filter with the longest inactive period (3 years) and work your way up.
        </div>
    </div>

    <div class="mb-4">
        <div class="m-4 flex flex-row items-center justify-end">
            <div class="mt-1 p-2 text-right text-lg">
                <label for="carbon_sub">Select only players who were NOT active before</label>
            </div>
            <div class="p-2">
                <select id="carbon_sub" wire:model.change="carbon_sub">
                    <option value="now">No limit</option>
                    <option value="6 months">6 months</option>
                    <option value="1 year">1 year</option>
                    <option value="2 years">2 years</option>
                    <option value="3 years">3 years</option>
                </select>
            </div>
        </div>
        <div class="mr-4 whitespace-nowrap text-right">
            {{ $users->count() }} users selected ordered by {{ Str::replace('_', ' ', $orderBy) }}
            {{ $asc ? 'ascending' : 'descending' }}
        </div>
    </div>

    <table class="table min-w-max table-auto">
        <thead class="whitespace-nowrap">
            <tr>
                <th class="bg-gray-200 p-2">
                    <div class="cursor-pointer">
                        <x-svg.sort-solid color="fill-green-700" wire:click="sortColumn('id')" />
                    </div>
                </th>
                <th class="bg-gray-200 p-2 text-left text-gray-900">
                    Name
                    <x-svg.sort-solid
                        class="cursor-pointer"
                        color="fill-green-700"
                        wire:click="sortColumn('name')"
                    />
                </th>
                @if ($show_email)
                    <th class="bg-gray-200 p-2 text-left text-gray-900">Email</th>
                @endif

                <th class="bg-gray-200 p-2 text-left text-gray-900">Contact Nr</th>
                <th class="flex flex-row bg-gray-200 p-2 text-gray-900">
                    <div>Last game</div>
                    <div class="cursor-pointer">
                        <x-svg.sort-solid
                            color="fill-green-700"
                            wire:click="sortColumn('last_game')"
                        />
                    </div>
                </th>
                <th class="bg-gray-200 p-2 text-left">Played for</th>
                <th class="bg-gray-200 p-2">
                    <x-svg.circle-user-solid color="fill-green-700" />
                    <x-svg.sort-solid
                        class="cursor-pointer"
                        color="fill-green-700"
                        wire:click="sortColumn('players_count')"
                    />
                </th>
                <th class="bg-gray-200 p-2">
                    Games
                    <x-svg.sort-solid
                        class="cursor-pointer"
                        color="fill-green-700"
                        wire:click="sortColumn('games_count')"
                    />
                </th>
                <th class="bg-gray-200 p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr
                    class="whitespace-nowrap border border-b-indigo-700"
                    wire:key="{{ $user->id }}"
                >
                    <td class="p-2 text-left text-gray-400">
                        {{ $user->id }}
                    </td>
                    <td class="p-2 font-bold">
                        {{ $user->name }}
                    </td>
                    @if ($show_email)
                        <td
                            @class(['p-2', 'text-gray-400' => str($user->email)->contains('@pgbilliard.com')])
                        >
                            {{ $user->email }}
                        </td>
                    @endif

                    <td class="p-2">
                        {{ $user->contact_nr }}
                    </td>
                    <td class="p-2">
                        {{ $user->last_game ? $user->last_game->format('d/m/Y') : 'unknown' }}
                    </td>
                    <td class="p-2 font-bold">
                        {{ $user->players->first()?->team ? $user->players->first()->team->name : '---' }}
                    </td>
                    <td class="p-2 text-center">
                        {{ $user->players_count }}
                    </td>
                    <td class="p-2 text-center">
                        {{ $user->games_count }}
                    </td>
                    <td class="p-2 text-center">
                        @if ($user->games_count)
                            <x-svg.user-check-solid
                                class="cursor-not-allowed"
                                color="fill-green-700"
                                size="6"
                            />
                        @else
                            <x-svg.user-minus-solid
                                class="cursor-pointer"
                                color="fill-red-700"
                                size="6"
                                wire:click="deleteUser({{ $user->id  }})"
                                wire:confirm="Delete {{ $user->name }}? This can't be undone."
                            />
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

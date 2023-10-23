<section>
    <x-title title="Claim an open user account"/>
    <div class="border border-gray-500 p-4 mb-5 text-justify">
        <div class="text-2xl">What is this page about?</div>
        <p class="my-3">
            Because the database is rebuild from scratch, <strong>all players</strong> are linked to a <strong>user</strong>
            in the <i>users</i> table. To accomplish this, I had to link players to a <strong>temporarily</strong> user account
            with a bogus email address.
        </p>
        <p class="my-3">
            The list underneath is build up from the <i>old</i> database. Mainly, only <strong>captains</strong> are in the list.
            As a result, <strong>it is perfectly possible you are not in the list at all</strong>. Because in recent seasons,
            we didn't add all the team players. You will recognize some player names from the past. For better or for worse.
            It's the way it is.
        </p>
        <p class="my-3">
            To help you to determine if you are listed here, you can see your <strong>last playing date</strong> and the
            <strong>team you played for</strong>.
        </p>
        <p class="my-3">
            <strong>User names have to be unique!</strong> For that reason alone, you should claim your account if are you in the list.
            There can only be one Richard or one Ann. If you are twice in the list because of misspelling, <strong>claim one</strong> and
            <a class="border border-white font-semibold text-blue-700 hover:bg-blue-100 hover:border hover:border-blue-700"
               href="mailto:admin@puertopool.com?subject=[PuertoPool] Double account names">send me an email</a>
            so I can fix it directly in the database.
        </p>
        <p class="my-3">
            If you are not in the list, simply
            <a class="border border-white font-semibold text-blue-700 hover:bg-blue-100 hover:border hover:border-blue-700"
               href="{{ route('register') }}" wire:navigate>create a new account</a>.
        </p>
        <p class="my-3">
            If you are listed, <strong>claim the account</strong>. <strong>Change your email address</strong>
            <span class="text-red-700">(this is important, so you can reset your password and receive notifications!)</span>
            and <strong>change your password</strong>. The current password is '<strong>secret</strong>' for all bogus accounts.
        </p>
        <p class="my-3">
            This page is temporarily and <strong>will disappear in the near future</strong>. <u>Please be thoughtful!</u>
            Claiming an account that is not yours will bring yourself in a stranger spot than me.
        </p>
        <p class="mt-3 text-xl">
            That's it!
        </p>
        <p>Yours, Dimitri</p>
    </div>


    <table class="table-auto md:table-fixed min-w-full">
        <theader class="whitespace-nowrap">
            <tr>
                <th class="p-2 text-left">Name</th>
                <th class="p-2 text-left">Email address</th>
                <th class="p-2 text-left">Claim</th>
                <th class="p-2 text-left">Last game</th>
                <th class="p-2 text-left">Last team</th>
            </tr>
        </theader>
        <tbody class="whitespace-nowrap">
        @foreach($users as $user)
            <tr wire:key="{{ $user->id }}">
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">
                    <a
                        class="border border-white font-semibold text-blue-700 hover:bg-blue-100 hover:border hover:border-blue-700"
                        href="/players/claim/{{ $user->id }}"
                    >
                        Claim...
                    </a>
                </td>
                <td class="p-2">{{ $user->last_game->format('d-m-Y') }}</td>
                <td class="p-2">
                    {{ $user->players()->orderByDesc('team_id')->first()->team->name }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</section>

<div class="flex flex-col space-y-3">
    <div class="font-bold">
        You have to be a little bit careful here. Any user you delete can not be undone. There is a
        failsafe.
    </div>
    <ul class="list-inside list-disc">
        <li class="list-item">
            <span class="font-bold">Administrators</span>
            can not be deleted
        </li>
        <li class="list-item">
            Users (players) with registered individual games can not be deleted
        </li>
    </ul>
    <div>
        The table is best viewed on
        <span class="font-bold">bigger screens</span>
        . The columns are as following:
    </div>
    <ul class="list-inside list-disc">
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
            each user has. Every Season creates a new player. Changing teams creates a new player as
            well. It gives an indication of how long the player has participated in the League
        </li>
        <li class="list-item">
            <span class="font-bold">Games</span>
            is the amount of registered individual games the player has. Singles and doubles
        </li>
    </ul>
    <div>
        Users with
        <x-svg.user-check-solid class="cursor-not-allowed" color="fill-green-700" size="6" />
        can not be deleted. It means they have individual games.
    </div>
    <div>
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

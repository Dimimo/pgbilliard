<div class="text-justify">
    <div class="mb-4 border-2 border-yellow-500 bg-yellow-100 p-4">
        <span class="font-bold">Disclaimer:</span>
        on the captains meeting of the 5th of March 2025 it has been agreed that the maximum amount
        of players allowed to a team is capped at
        <span class="font-bold">{{ \App\Constants::MAX_TEAM_PLAYERS }}</span>
        .
    </div>
    <div class="mb-4">
        At first, you will find this page boring. But it is actually very interesting and
        <span class="font-bold">important for Bar owners and Captains</span>
        .
    </div>
    <div class="mb-4">Let me explain...</div>
    <div class="mb-4">
        <span class="font-bold">Teams and where they play</span>
        are obvious. The number next to it are the number of players added to the team. In the
        future, it should be at least 4.
    </div>
    <div class="mb-4">
        Finally, the Captain and the contact number. If the Captain is not set or the Captain didn't
        fill in the contact number, the fall-back number you see is of the bar owner. In case you
        need to move a date, or you will be later than expected, you find who to contact on this
        page.
    </div>
    <div class="mb-4 font-bold">
        For understandable reasons, all phone numbers are hidden for visitors. In order to see a
        contact number you need to be
        <a href="{{ route('login') }}" class="link inline-block text-blue-800" wire:navigate>
            Logged In
        </a>
        !
    </div>
    <div class="font-bold">Bar owners and Captains</div>
    <div class="mb-4">
        Bar owners and Captains may notice a
        <x-svg.pen-to-square-solid color="fill-blue-600" size="4" />
        sign next to some names. This means you have access to change what's underneath. For Bar
        owners that would be the information of the bar, the team(s) and the players of the team(s).
        Including who to appoint as a captain. Appointing the teams itself is done by an
        administrator as it is part of the schedule in the current Season.
    </div>
    <div class="font-bold">Captains</div>
    <div class="mb-4">
        Captains (and Bar owners) can add who is playing in the team. I made it as simple as
        possible. Just read the instructions on the page if you have any questions. A mistake is
        very easily undone by the way. Except... if you unset yourself as a captain... Well, you get
        a warning before doing so. Removing a team player gives a warning as well. Anyway, it's easy
        to add or remove players.
    </div>
    <div class="mb-4">
        <span class="font-bold">Players that are already in another team can not be selected.</span>
        If the player is new and not in the database, simply add a new player. Names have to be
        unique. A warning is given if the name is already in use. After creating a new user, you
        will receive an email with the data your new team member needs in order to log in and change
        their credentials.
    </div>
    <div class="mb-4 border-2 border-gray-500 bg-gray-100 p-4">
        <div class="mb-2 font-bold">Players leaving or switching to another team</div>
        <div class="mb-2">
            If a player leaves and won't come back (holiday is over f.ex.) OR a player wants to
            switch to another team,
            <span class="font-bold">you can safely remove the player from the list</span>
            . Doing so HAS NO impact on past games.
        </div>
        <div class="mb-2">
            <span class="font-bold">How does it works under the hood?</span>
            The player gets
            <span class="italic">deactivated</span>
            . (S)he is still in the league, but has no more attachment to a team. If the player
            comes back OR switches team, the player's status is updated accordingly.
        </div>
        <div class="mb-2">
            <span class="font-bold">For Captains:</span>
            a player that is deactivated becomes available to invite into any team.
        </div>
        <div>
            A player's status OR team has no influence on
            <a href="{{ route('rank') }}" class="link inline-block text-blue-800" wire:navigate>
                the individual scoreboard
            </a>
            .
        </div>
    </div>
    <div class="mb-6">
        That's about it. Cheerio and
        <span class="font-bold">Have Fun!</span>
    </div>
</div>

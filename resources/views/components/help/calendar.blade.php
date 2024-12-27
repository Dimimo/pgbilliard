<div class="text-justify">
    <div class="mb-4">
        The Calendar gives you an overview of the current Season. When and where you play. Simple. With the results of past games <a
            class="font-bold text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('scoresheet') }}"
            wire:navigate
        >
            that determine the current ranking of your team
        </a>
    </div>
    <div class="mb-4">
        Winning teams <span class="font-bold">are shown in bolder text</span>. If you are logged in and participate
        in the current season, the team you play in <span class="bg-green-50 p-1">has a greenish background</span>.
    </div>
    <div class="mb-4">
        You may click on the white space between the team name and the score to give any other team
        <span class="bg-green-50 p-1">the same greenish background</span> in the current session.
    </div>
    <div class="mb-4 font-bold">
        If, for some reason, your team doesn't play home, the bar (or Venue) will be shown right under it.
        <span class="text-red-700">In red letters</span> so you won't miss it.
    </div>
    <div class="mb-4 rounded-lg border border-gray-300 bg-gray-50 p-2">
        An email, <span class="font-bold">as a reminder</span>, will be sent to you the day before the game, at noon.
        If you didn't get any email, some of the next requirements are not met: <br class="mb-2">
        1/ you are not subscribed <br>
        2/ you gave the wrong email address <br>
        3/ Ormeco <br>
        4/ <a
            class="text-blue-800 hover:text-blue-600 hover:underline"
            href="{{ route('teams.index') }}"
            wire:navigate
        >
            you don't appear as a player in your team
        </a><br class="mb-2">
        If the latter is true, ask the bar or the captain of your team. They can add you!<br>
        <span class="italic text-sm">(reminder: for the moment, this website is still in beta)</span>
        {{-- todo: remove this once the beta is over --}}
    </div>
    <div class="mb-4">
        Special dates have a subtitle. Usually the semi-finals, final and party.
    </div>
    <div class="mb-4">
        Dates may be skipped due to special holidays as Christmas or the New Year. Extraordinary circumstances,
        such as a typhoon, may move the calendar dates up one week.
        Only administrators have access to create and change the dates.
    </div>
    <div class="mb-4">
        You may not have noticed: every team has its own page. Just click on the name. It shows the Calendar overview of the
        team you play for and the results of past games.
    </div>
    <div class="mb-4">
        I hope to create a PDF file by the next Season, so you can print it out. Personalized to make your schedule more visible.
    </div>
    <div>
        That's about it. Cheerio and <span class="font-bold">Have Fun!</span>
    </div>
</div>

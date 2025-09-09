<div class="text-justify">
    <div class="pt-4 text-lg underline">
        Website updates and improvements
    </div>

    <ul class="ml-6 list-disc">
        <li>all contact numbers are hidden for visitors</li>
        <li>the good old big navigation buttons are back, only for the scores, calendar and teams</li>
        <li>the help files are finished</li>
        <li>the help files have a popup link to a modal on the appropriate pages</li>
        <li>chat messages can be deleted, but alas, the chat itself is not yet fully functional 😒</li>
        <li>Season Structure overview: create a new team with a popup,</li>
        <li>Season Structure overview: the list of potential captains omits occupied players</li>
        <li>I found a way to make the chat work: a reload of the messages every 2 seconds... well, it works and that is what counts</li>
        <li>The Day Schedule is finally finished, took me only 6 days to get it right...</li>
        <li>Finished the Dashboard, an individual overview of the logged in player and their role in the selected (usually current) season</li>
        <li>The players scoreboard is for later, when there is data to work with...</li>
        <li>The database table ('games'), which holds the needed player's data, will make the players scoreboard easy...</li>
        <li>...even if a players switches teams during the season (a win is both for the player AND the team at the set date)</li>
        <li>The day schedule should be finished, tested and approved</li>
        <li>To avoid confusion, the WINNER gets a bonus of 30% extra, the runner-up 15% extra on the percentage</li>
        <li><a href="{{ route('logs') }}" class="inline-block text-blue-800 link" wire:navigate>
                The log file of given scores
            </a> is accessible by everybody
        </li>
        <li>
            Added <a href="{{ route('help.changelog') }}" class="inline-block text-blue-800 link" wire:navigate>the changelog overview</a>
        </li>
        <li>
            The maximum number of players allowed to a team is now limited to {{ \App\Constants::MAX_TEAM_PLAYERS }} as agreed on the Captains Meeting
        </li>
        <li>
            The <a href="{{ route('help.changelog') }}" class="inline-block text-blue-800 link" wire:navigate>
                The Rules of the Puerto Galera Billiard League
            </a> have been added for online reference.
            <span class="font-bold">A big thanks to Rob for the work and print-outs</span> and ChatGPT for the digital version!
        </li>
        <li>The collision on daily schedule live updates is fixed.</li>
        <li>For Admins: the maximum amount of players a Season allows is now Season dependable.</li>
        <li>
            For Admins: an empty Season can be deleted if there are no games (events) and has only 1 date.
            Teams and players get deleted as well. In case of a fresh new Season reset is requested.
        </li>
        <li>
            Extra check of the 15th game (last double) added. If the 4 players are not selected, no checkboxes appear.
        </li>
        <li>The last updated score is highlighted in color. On the Scoreboard, the Calendar and daily overview.
        <li>
        <li>The individual ranking is now available <span class="font-bold">but still in beta!</span></li>
        <li>For Admins: you may send out emails to Captains and/or Players</li>
        <li>
            On a live event scoresheet, the player on the break has
            <span class="rounded-lg border border-neutral-400 bg-neutral-100 px-1">a grayish background</span>.
        </li>
        <li>Set the experimental individual ranking to the original idea</li>
        <li>The one female rule has been dropped (Captains Meeting agreement on the 2nd of June 2025)</li>
        <li>Aug 10, 2025: finally fixed the bug on the day schedule selecting the players</li>
        <li>
            Sep 9, 2025: <span class="font-bold">the chat has been disabled</span>;
            looking to create a Google Play app, a chat complicates the review process
        </li>
        <li>
            Sep 9, 2025: added the privacy policy as demanded by Google in order to publish a App Package on Google Store
        </li>
    </ul>
</div>
<div class="mt-4">
    For ALL changes, I refer to
    <a href="https://github.com/Dimimo/pgbilliard/commits/main/" class="inline-block text-blue-800 link" target="_blank">
        the extended list of GitHub commits 🤞
    </a>
</div>

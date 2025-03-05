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
        <li>Added <a href="{{ route('help.changelog') }}" class="inline-block text-blue-800 link" wire:navigate>the changelog overview</a></li>
    </ul>
</div>
<div class="mt-4">
    For ALL changes, I refer to
    <a href="https://github.com/Dimimo/pgbilliard/commits/main/" class="inline-block text-blue-800 link" target="_blank">
        the extended list of GitHub commits 🤞
    </a>
</div>

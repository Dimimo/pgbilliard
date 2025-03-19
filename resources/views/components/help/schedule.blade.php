<div class="text-justify">
    <div class="mb-4">
        When you see <span class="font-bold">create day sheet</span>, you can start the daily individual day sheet.
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">The view of the calendar day overview</div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/day_score_ready.png') }}" alt="">
        </div>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Following the link, gives you 2 options, the 'old' and the 'new' daily schedule
            </div>
        </div>
        <div class="m-4 flex flex-col justify-center space-y-2">
            <img src="{{ secure_url('/images/schedule/new_schedule.png') }}" alt="">
            <img src="{{ secure_url('/images/schedule/old_schedule.png') }}" alt="">
        </div>
    </div>

    <div class="mb-4">
        Take your pick, you can now enter your team members. The selected players will fill up the
        individual games one by one. You can still change any game later on.
        <span class="font-bold">Just make sure players don't play the same opponent</span> as before.
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Select your team members one by one as you did on the paper sheet.
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/home_team_select.png') }}" alt="">
        </div>
    </div>

    <div class="mb-4 text-lg text-red-700">
        If you move selected players around, there is a bug. You could see this for example.
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                Before adding the first score, please check for this anomaly
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/bug_doubles.png') }}" alt="">
        </div>
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                There is an easy fix, under you team click 'Reset the schedule' and simply enter the players again.
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/rest_schedule_button.png') }}" alt="">
        </div>
    </div>

    <div class="mb-4">
        The individual games overview should look similar to this:
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500 font-bold">
            <div class="rounded-t-lg bg-green-100 p-4">
                The first round, the 15th (3th double) is set to empty as expected
            </div>
        </div>
        <div class="m-4 flex flex-col justify-center space-y-2">
            <img src="{{ secure_url('/images/schedule/first_round_example.png') }}" alt="">
            <img src="{{ secure_url('/images/schedule/last_doubles_empty.png') }}" alt="">
        </div>
    </div>

    <div class="mb-6 w-full rounded-lg border-2 border-gray-500 text-center">
        <div class="border-b border-gray-500">
            <div class="rounded-t-lg bg-green-100 p-4">
                After you entered the first score (in this case Helen - Rhea) the drop-down choices of the players will be locked. <br>
                <span class="font-bold">
                    If you are not sure if a reserve will show up, add the player anyway! You can't change
                    the selected players after the game started.
                </span>
            </div>
        </div>
        <div class="m-4 flex justify-center">
            <img src="{{ secure_url('/images/schedule/selected_players_locked.png') }}" alt="">
        </div>
    </div>
</div>

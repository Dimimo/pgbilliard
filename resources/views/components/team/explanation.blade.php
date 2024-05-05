<div>
    <p class="my-2">
        If you <strong>create</strong> a new Season, the table will be empty. In case you requested a BYE, it is already created for your convenience.
        A list of teams appears on the bottom (select team {{ $i }}). Select a team appropriate for the new Season. It will copy the name, venue and
        captain to the table. Any value can still be changed.
    </p>
    <p class="my-2">
        if you <strong>update</strong> an existing Season, you can add teams, remove teams or add a BYE. Just click the button 'Add a BYE'. If a BYE is already in
        the table, the button 'Add a BYE' is invisible.
    </p>
    <p class="my-2">
        <strong>New teams can be added</strong> by choosing <strong>(Add a new team)</strong> from the select team {{ $i }} dropdown list. A generic name
        is provided with the Venue set at BYE. Obviously, you need to change it to appropriate values.
    </p>
    <p class="my-2">
        In case you want to <img class="inline-block mx-auto" src="{{ secure_asset('svg/minus-box-fill.svg') }}" alt="Remove" width="16" height="16">
        <strong>remove</strong> a team, make sure all games are deleted for this team first. <strong>A team with games can not be deleted.</strong>
        The same applies to a BYE. If the BYE still has 'games', remove them first.
    </p>
    <p class="my-2">
        <strong>You may leave the 'captain' choice empty</strong> if you are not sure. The bar owner can add the captain or it can be added later by an Admin.
        Don't forget that captains can add the players of their team themselves.
    </p>
    <p class="my-2">
        If you are happy with the update or creation of the teams in the Season, you may continue to the calendar by
        <strong>updating the table and continue to the calendar.</strong>
    </p>
</div>

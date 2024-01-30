@if(str_contains(URL::current(), 'calendar/update'))
    @php
        $new = false;
    @endphp
@else
    @php
        $new = true;
    @endphp
@endif

@if($new)
    <div class="text-2xl">How does it work?</div>
    <div class="my-2">
        When you created this new Season, a starting date and day of week, the first date has
        been created ({{ $dates->first()->date->format('Y-m-d') }}). Your starting point. Here
        you can fill in the games.
    </div>

    <div class="text-2xl">Create a game</div>
    <div class="my-2">
        Just make sure you are working on the correct date. The blue title and the 'Playing date'
        dropdown list shows you. On the right you will see an overview of the whole calendar you
        are creating. Only the <strong>teams</strong> are needed. The <strong>venue</strong> is
        automatically selected.
    </div>

@else
    <div class="text-2xl">Update an existing game</div>
    <div class="my-2">
        Make sure you select the correct playing date first. Games of a past date cannot be updated or
        deleted.
    </div>
@endif


<div class="text-2xl">Delete a game</div>
<div class="my-2">
    If you made a mistake, don't worry. Games on a selected date can be deleted and recreated.
    Games that already happened can not be deleted. Not even by Dimitri. It is the past.
</div>

<div class="mt-3 text-2xl">Add a new date</div>
<div class="my-2">
    When done with the current selected date, click on <span class="text-green-700">Add next week</span>.
    It will create the next date and select it to create the games corresponding to the selected new date.
</div>

<div class="mt-3 text-2xl">Add the results</div>
<div class="my-2">
    The results (scores) will be added later on the calendar. The <strong>first</strong> playing
    date will produce a score of 0-0 automatically. The overview needs <i>some</i> data to work with.
</div>

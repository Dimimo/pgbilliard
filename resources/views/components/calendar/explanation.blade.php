@props(['new', 'dates'])

@if($new === true)

    <div class="text-2xl">How does it work?</div>
    <div class="my-2">
        When you created a new Season with a starting date and day of the week, the first date has
        been created ({{ $dates->first()->date->format('Y-m-d') }}). Your starting point. Here
        you can fill in the games.
    </div>

    <div class="text-2xl">Create a game</div>
    <div class="my-2">
        Just make sure you are working on the correct date. The blue title and the 'Playing date'
        dropdown list shows you. On the right you will see an overview of the calendar you
        are creating. Only the <strong>teams</strong> are needed. The <strong>venue</strong> is
        automatically selected. The location can be changed, if necessary.
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
    If you made a mistake, don't worry. Games can be deleted and recreated.
    Games that already happened can not be deleted. Not even by Dimitri. It is the past.
</div>

<div class="mt-3 text-2xl">Add a new date</div>
<div class="my-2">
    When done with the current selected date, click on
    <img class="mx-auto inline-block" src="{{ secure_asset('svg/plus-box-fill.svg') }}" alt="" width="16" height="16"> <span class="text-green-700">Add next week</span>.
    Simple enough.
</div>
<div class="my-2">
    <strong><u>Hint</u>:</strong> If you want to skip a week (holidays for example), create 2 new dates and delete the holiday later.
</div>

<div class="text-2xl">Delete a date</div>
<div class="my-2">
    You can delete a date if there it has no games. If the date is somehow wrong, you
    will have to delete the games <img
        class="inline-block"
        src="{{ secure_asset('svg/minus-box-fill.svg') }}"
        alt="Remove"
        width="16"
        height="16"
    > first before the
    <img class="inline-block" src="{{ secure_asset('svg/delete-item.svg') }}" alt="" width="16" height="16">
    symbol appears. <span class="font-bold">Past games can not be deleted.</span> Past dates yes, if they have no games.
</div>

@if($new === true)

    <div class="mt-3 text-2xl">Conclude to the Overview</div>
    <div class="my-2">
        The results (scores) can be added later on the
        <x-nav-link :active="true" href="{{ route('calendar') }}" class="text-lg" wire:navigate>Calendar</x-nav-link>
        .
        The <strong>first</strong> playing date will produce a score of 0-0 automatically. The overview
        needs <i>some</i> data to work with.
    </div>

@else

    <div class="mt-3 text-2xl">Continue to the Calendar</div>
    <div class="my-2">
        When you are done modifying the curren Season, just click the bottom link, it will bring you back to the
        <x-nav-link :active="true" href="{{ route('calendar') }}" class="text-lg" wire:navigate>Calendar</x-nav-link>
        .
    </div>

@endif

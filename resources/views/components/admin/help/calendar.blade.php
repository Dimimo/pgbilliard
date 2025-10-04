@props(['new', 'dates'])

<div class="text-justify">
    @if ($new)
        <div class="text-2xl">How does it work?</div>
        <div class="my-2">
            When you created a new Season with a starting date and day of the week, the first date
            has been created ({{ $dates->first()->date->format('Y-m-d') }}). Your starting point.
            Here you can fill in the games.
        </div>

        <div class="text-2xl">Create a game</div>
        <div class="my-2">
            Just make sure you are working on the correct date. The blue title and the 'Playing
            date' dropdown list shows you. On the right you will see an overview of the calendar you
            are creating. Only the
            <strong>teams</strong>
            are needed. The
            <strong>venue</strong>
            is automatically selected. The location can be changed, if necessary. A warning is given
            just in case. Click 'create this game' and done.
        </div>
    @else
        <div class="text-2xl">Update an existing game</div>
        <div class="my-2">
            Make sure you select the correct playing date first. Games of a past date cannot be
            updated or deleted.
        </div>
    @endif

    <div class="text-2xl">Delete a game</div>
    <div class="my-2">
        If you made a mistake, don't worry. Games can be deleted and recreated. Games that are
        <span class="font-bold">confirmed</span>
        can not be deleted.
    </div>

    <div class="mt-3 text-2xl">Add a new date</div>
    <div class="my-2">
        When done with the current selected date, click on
        <x-svg.square-plus-solid color="fill-green-700" size="4" padding="mb-1" />
        <span class="text-green-700">Add next week</span>
        . Simple enough.
    </div>
    <div class="my-2">
        <div class="font-bold">Hints:</div>
        If you want to skip a week (holidays for example), create 2 new dates and delete the holiday
        later.
        <br />
        If a certain date can't be on a {{ $dates->first()->date->format('l') }}, you can shift it
        in the Admin section 'Change a playing date' later on.
    </div>

    <div class="text-2xl">Delete a date</div>
    <div class="my-2">
        You can delete a date if it has no games. If the date is somehow wrong, you will have to
        delete the games
        <x-svg.square-minus-solid color="fill-orange-400" size="4" padding="mb-1" />
        first before the
        <x-svg.trash-can-solid color="fill-red-600" size="4" padding="mb-1" />
        symbol appears.
        <span class="font-bold">Confirmed games can not be deleted.</span>
        Past dates yes, if there are no games.
    </div>

    <div class="text-2xl">Delete a Season</div>
    <div class="my-2">
        A Season can be deleted if it has no dates. If there is only one date left without games,
        you can delete the season. Just in case you make a mistake with the opening tag of a new
        season (in this case Season {{ $dates->first()->season->cycle }}).
    </div>

    @if ($new)
        <div class="mt-3 text-2xl">Conclude to the Overview</div>
        <div class="my-2">
            The results (scores) can be added later on the
            <a
                href="{{ route('calendar') }}"
                class="link inline-block text-lg text-blue-800 hover:text-blue-600"
                wire:navigate
            >
                Calendar
            </a>
            . The
            <strong>first</strong>
            playing date is automatically set to 0-0. The Scoreboard needs
            <i>some</i>
            data to work with.
        </div>
    @else
        <div class="mt-3 text-2xl">Continue to the Calendar</div>
        <div class="my-2">
            When you are done modifying the curren Season, just click the bottom link, it will bring
            you back to the
            <x-forms.nav-link
                :active="true"
                href="{{ route('calendar') }}"
                class="text-lg"
                wire:navigate
            >
                Calendar
            </x-forms.nav-link>
            .
        </div>
    @endif
</div>

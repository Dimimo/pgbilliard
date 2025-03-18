<x-mail::message>
# Your game tomorrow, the {{ $date->date->format('jS \o\f M Y') }}:

## {{ $event->team_1->name }} - {{ $event->team_2->name }} @ {{ $event->venue->name }}

The games starts at 2pm as agreed in the last Team meeting. <br>
Some Captains prefer and may agree to start at 1pm.

<x-mail::button :url="route('calendar')">
Calendar
</x-mail::button>

Good luck to you all!<br>
{{ config('app.name') }}
</x-mail::message>

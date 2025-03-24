<x-mail::message>
# Your game tomorrow, the {{ $date->date->format('jS \o\f M Y') }}:

## {{ $event->team_1->name }} - {{ $event->team_2->name }} @ {{ $event->venue->name }}

The games starts at 2pm as agreed in the last Team meeting. <br>
Some Teams prefer and may agree to start at 1pm. Please check with your captain.

<x-mail::button :url="route('calendar')">
Calendar
</x-mail::button>

Good luck to you all!<br>
The Puerto Galera Billiard League
</x-mail::message>

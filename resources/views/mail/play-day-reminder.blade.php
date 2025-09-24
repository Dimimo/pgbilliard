<x-mail::message>
# Your game tomorrow, the {{ $date->date->format('jS \o\f M Y') }}: ##
{{ $event->team_1->name }} - {{ $event->team_2->name }} @ {{ $event->venue->name }} The games
starts at 1pm. Some Teams prefer and may agree to start at 2pm. Please check with your captain.

<x-mail::button :url="route('calendar')">Calendar</x-mail::button>

<x-mail::panel>
### All planned games:
@foreach ($date->events as $game)
@if ($game != $event)
{{ $game->team_1->name }} - {{ $game->team_2->name }} @ {{ $game->venue->name }}
<br />
@endif
@endforeach
</x-mail::panel>

Good luck to you all!
<br />
The Puerto Galera Billiard League
</x-mail::message>

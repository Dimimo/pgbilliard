<x-mail::message>
# Your game tomorrow, the {{ $date->date->format('jS \o\f M Y') }}: ##
@if ($event->team_2->name !== 'BYE')
{{ $event->team_1->name }} - {{ $event->team_2->name }} @ **{{ $event->venue->name }}**
<br /><br />
The games starts at 2pm. Some Teams prefer and may agree to start at 1pm. Please check with your captain.
@else
Your team **{{ $event->team_1->name }}** has a BYE.
@endif

<x-mail::button :url="route('calendar')">Calendar</x-mail::button>

<x-mail::panel>
### Planned games:
@foreach ($date->events as $game)
{{ $game->team_1->name }} - {{ $game->team_2->name }}
@if($game->team_2->name !== 'BYE')
@ {{ $game->venue->name }}
@endif
<br />
@endforeach
</x-mail::panel>

Good luck to all Teams and Players!
</x-mail::message>

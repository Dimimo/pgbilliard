<x-mail::table>
    | Home Team | Visitors | Score | |:---------:|:---------:|:---------:|
    @foreach ($date->events as $event)
            | {{ $event->team_1->name }} | {{ $event->team_2->name }} | {{ $event->score1 }} -
            {{ $event->score2 }} |
    @endforeach
</x-mail::table>

<x-mail::button :url="route('scoreboard')">Scoreboard</x-mail::button>

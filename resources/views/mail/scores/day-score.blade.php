<x-mail::message>
# {{ $subject }}

<x-mail::table>
| Home Team | Visitors  |   Score   |
|:---------:|:---------:|:---------:|
@foreach($date->events as $event)
| {{ $event->team_1->name }} | {{ $event->team_2->name }} | {{ $event->score1 }} - {{ $event->score2 }} |
@endforeach
</x-mail::table>

<x-mail::button :url="route('scoresheet')">
Scoresheet
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

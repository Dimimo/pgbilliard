<x-mail::message>
# These day score results have been sent to:
@foreach($mail_to as $name)
- {{ $name }}
@endforeach

<x-mail::panel>
@include('mail.scores._day-score-body')
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

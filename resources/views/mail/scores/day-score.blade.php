<x-mail::message>
    # {{ $subject }}

    @include('mail.scores._day-score-body')

    Thanks,
    <br />
    {{ config('app.name') }}
</x-mail::message>

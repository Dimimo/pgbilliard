<x-mail::message>
    # Your team member needs the following information

    <x-mail::panel>**username**: {{ $user->email }} **password**: secret</x-mail::panel>

    Please ask to log in and change these values

    <x-mail::button :url="'/login'">the log in page</x-mail::button>

    Thanks,
    <br />
    The Puerto Galera Billiard League
</x-mail::message>

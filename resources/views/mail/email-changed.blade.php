<x-mail::message>
# Your email has been changed

This is a confirmation. If you requested the change all is good!

Don't forget to change your password too if you claimed your account.

<x-mail::button :url="'/profile'">
Your profile
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

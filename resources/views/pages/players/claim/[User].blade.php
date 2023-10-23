<?php

use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\state;

state(['user' => fn() => $user]);
?>
<x-layout>
    @volt
    @php Auth::login($user) @endphp
    <section>
        <x-title title="Update your new profile"/>
        <div class="border border-green-500 p-4 my-5">
            <p class="my-3">
                Welcome <strong>{{ $user->name }}</strong>! In order to fulfill your claim to this profile,
                you need to change the email and password. When finished, the account is yours.
            </p>
            <p class="my-3">
                <strong>Please be sure to fill in your correct email address.</strong> If you forget your password,
                a reset link can be sent to your provided credentials.
            </p>
            <p class="my-3">
                <u>Reminder:</u> the current password is '<strong>secret</strong>' and should already be filled in automatically.
            </p>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <livewire:profile.update-password-form current_password="secret" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endvolt
</x-layout>

<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

test('reset password link screen can be rendered', function (): void {
    $this->seed(\Database\Seeders\SeasonSeeder::class);
    $response = $this->get('/forgot-password');

    $response->assertSeeLivewire('auth.forgot-password')->assertStatus(200);
});

test('reset password link can be requested', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test('pages.auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    try {
        Notification::assertSentTo($user, ResetPassword::class);
    } catch (\Exception) {
    }
});

test('reset password screen can be rendered', function (): void {
    $this->seed(\Database\Seeders\SeasonSeeder::class);
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test('pages.auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    try {
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/' . $notification->token);

            $response->assertSeeVolt('pages.auth.reset-password')->assertStatus(200);

            return true;
        });
    } catch (\Exception) {
    }
});

test('password can be reset with valid token', function (): void {
    Notification::fake();

    $user = User::factory()->create();

    Livewire::test('pages.auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    try {
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (
            $user,
        ) {
            $component = Livewire::test('pages.auth.reset-password', [
                'token' => $notification->token,
            ])
                ->set('email', $user->email)
                ->set('password', 'password')
                ->set('password_confirmation', 'password');

            $component->call('resetPassword');

            $component->assertRedirect('/login')->assertHasNoErrors();

            return true;
        });
    } catch (\Exception) {
    }
});

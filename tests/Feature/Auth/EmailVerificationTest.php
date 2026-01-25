<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

test('email verification screen can be rendered', function (): void {
    $this->seed(\Database\Seeders\SeasonSeeder::class);
    User::unguard();
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);
    User::reguard();

    $this->actingAs($user);

    \Livewire\Volt\Volt::test('pages.auth.verify-email')->assertOk();
});

test('email can be verified', function (): void {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $user = user::first();
    $user->unguard();
    $user->update([
        'email_verified_at' => null,
    ]);
    $user->reguard();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $response = $this->actingAs($user)
        ->get($verificationUrl)
        ->assertStatus(302);

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect(RouteServiceProvider::HOME.'dashboard?verified=1');
});

test('email is not verified with invalid hash', function (): void {
    User::unguard();
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);
    User::reguard();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($user)->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

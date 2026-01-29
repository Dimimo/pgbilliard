<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $this->user = user::query()->first();
});

test('confirm password screen can be rendered', function (): void {
    $response = $this->actingAs($this->user)->get('/confirm-password');

    $response
        ->assertSeeVolt('pages.auth.confirm-password')
        ->assertStatus(200);
});

test('password can be confirmed', function (): void {
    $this->actingAs($this->user);

    $component = Volt::test('pages.auth.confirm-password')
        ->set('password', 'password');

    $component->call('confirmPassword');

    $component
        ->assertRedirect('/')
        ->assertHasNoErrors();
});

test('password is not confirmed with invalid password', function (): void {
    $this->actingAs($this->user);

    $component = Volt::test('pages.auth.confirm-password')
        ->set('password', 'wrong-password');

    $component->call('confirmPassword');

    $component
        ->assertNoRedirect()
        ->assertHasErrors('password');
});

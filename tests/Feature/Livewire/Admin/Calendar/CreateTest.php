<?php

use App\Livewire\Admin\Calendar\Create;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $season = \App\Models\Season::factory()->create();

    $admin = \App\Models\User::factory()->create(['name' => 'admin']);
    \App\Models\Admin::factory()->create(['user_id' => $admin->id]);
    session(['is_admin' => true]);

    Livewire::actingAs($admin)->test(Create::class, ['season' => $season])
        ->assertStatus(302);
});

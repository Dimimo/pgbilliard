<?php

use App\Models\Season;
use Illuminate\Support\Facades\Context;

it('renders successfully', function (): void {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $season = Season::first();
    Context::addHidden([
        'cycle' => $season->cycle,
        'season_id' => $season->id,
    ]);

    $admin = \App\Models\User::factory()->create(['name' => 'admin']);
    \App\Models\Admin::factory()->create(['user_id' => $admin->id]);
    session(['is_admin' => true]);

    $this->actingAs($admin);
    $this->get('admin/teams/create')->assertOk();
});

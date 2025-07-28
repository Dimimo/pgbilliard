<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\User;
use Illuminate\Container\Attributes\Context as ContextAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Context;

class NewPlayersSeeder extends Seeder
{
    public function run(
        #[ContextAttribute('teams')] array $teams,
    ): void {
        foreach ($teams as $team) {
            if ($team->name !== 'BYE') {
                for ($i = 1 ; $i <= 4 ; $i++) {
                    $user = User::factory()->create([
                        'name' => "user $i team $team->id",
                    ]);

                    $player = Player::factory()->create([
                        'user_id' => $user->id,
                        'team_id' => $team->id,
                        'captain' => $i === 1,
                    ]);

                    Context::push('users', $user);
                    Context::push('players', $player);
                }
            }
        }
    }
}

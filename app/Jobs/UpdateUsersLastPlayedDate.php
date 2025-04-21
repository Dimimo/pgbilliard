<?php

namespace App\Jobs;

use App\Models\User;

class UpdateUsersLastPlayedDate
{
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::select(['id', 'last_game'])->get();
        foreach ($users as $user) {
            $player = $user->players()->latest()->get()->first();
            if ($player) {
                $game = $player->games()->latest()->first();
                if ($game) {
                    $date = $game->event->date->date;
                    if ($date) {
                        $user->update(['last_game' => $date]);
                    }
                }
            }
        }
    }
}

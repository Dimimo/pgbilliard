<?php

namespace App\Jobs;

use App\Mail\PlayDayEmailReminder;
use App\Models\Date;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;

class PlayDayReminder
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $date = $this->getDate();
        if (!$date) {
            return;
        }
        $send_to = [];
        $players = $date->players();

        foreach ($players as $user) {
            // avoid players that haven't been claimed yet
            if (!Str::contains($user->email, '@pgbilliard.com')) {
                $team = $date->getTeam($user);
                \Mail::to($user)->queue(new PlayDayEmailReminder($date, $team));
                $send_to = \Arr::add($send_to, $user->id, $user->name);
            }
        }
        \Log::info('The reminder emails have been sent, ' . count($send_to) . ' players');
    }

    //first check if the date tomorrow exists, if not, it returns null
    private function getDate(): ?Date
    {
        $date = now()->appTimezone()->addDay()->format('Y-m-d');

        return Date::query()->where('date', $date)->first();

    }
}

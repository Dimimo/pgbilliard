<?php

namespace App\Jobs;

use App\Mail\RemindCaptainOfNewUser;
use App\Models\User;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Str;

class CaptainCreatedNewUser
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Mail::to(auth()->user())->queue(new RemindCaptainOfNewUser($this->user));
        if (!Str::contains($this->user->email, '@pgbilliard.com')) {
            \Mail::to($this->user)->queue(new RemindCaptainOfNewUser($this->user));
        }
    }
}

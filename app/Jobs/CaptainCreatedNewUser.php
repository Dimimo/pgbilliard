<?php

namespace App\Jobs;

use App\Mail\RemindCaptainOfNewUser;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CaptainCreatedNewUser implements ShouldQueue
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
    }
}

<?php

namespace App\Jobs;

use App\Mail\AccountClaimed;
use App\Models\User;
use Illuminate\Foundation\Queue\Queueable;

class AccountHasBeenClaimed
{
    use Queueable;

    public string $subject = '';

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
    ) {
        $this->subject = $this->user->name . " has claimed their account";
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Mail::to($this->user)->queue(new AccountClaimed($this->user, $this->subject));
    }
}

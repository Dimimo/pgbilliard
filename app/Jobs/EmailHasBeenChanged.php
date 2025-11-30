<?php

namespace App\Jobs;

use App\Mail\EmailChanged;
use App\Models\User;
use Illuminate\Foundation\Queue\Queueable;

class EmailHasBeenChanged
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Illuminate\Support\Facades\Mail::to($this->user)->queue(new EmailChanged());
    }
}

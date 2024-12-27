<?php

namespace App\Mail;

use App\Models\Date;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DayScoresToAdmin extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Date $date,
        public array $mail_to,
    ) {
        $this->subject = 'Day scores results of '
            . $this->date->date->format('d/m/Y')
            . ' send to '
            . count($this->mail_to)
            . ' players';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                new Address(config('mail.admin_to.address'), config('mail.admin_to.name'))
            ],
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.scores.day-score-admin',
        );
    }
}

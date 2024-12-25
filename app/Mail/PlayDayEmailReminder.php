<?php

namespace App\Mail;

use App\Models\Date;
use App\Models\Event;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlayDayEmailReminder extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public Event $event;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Date $date,
        public Team $team
    ) {
        $this->event = $this->date
            ->events()
            ->where('team1', $this->team->id)
            ->orWhere('team2', $this->team->id)
            ->first();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[PG Billiard] Game Reminder for tomorrow at ' . $this->event->venue->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'play-day-reminder',
        );
    }
}

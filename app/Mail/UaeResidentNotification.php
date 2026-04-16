<?php

namespace App\Mail;

use App\Models\UaeResident;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UaeResidentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public UaeResident $resident
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Diaspora Registration - ' . $this->resident->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.uae-resident-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

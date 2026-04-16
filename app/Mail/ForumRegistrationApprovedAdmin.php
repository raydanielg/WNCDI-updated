<?php

namespace App\Mail;

use App\Models\ForumRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForumRegistrationApprovedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ForumRegistration $registration
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Forum Registration Approved - ' . $this->registration->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.forum-registration-approved-admin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Mail;

use App\Models\ForumRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForumRegistrationUserConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public ForumRegistration $registration;

    public function __construct(ForumRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function build(): self
    {
        return $this->subject('Your forum registration has been received')
            ->view('emails.forum_registration_user_confirmation');
    }
}

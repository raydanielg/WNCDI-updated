<?php

namespace App\Mail;

use App\Models\TanfordMember;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TanfordMemberWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public TanfordMember $member;

    public function __construct(TanfordMember $member)
    {
        $this->member = $member;
    }

    public function build(): self
    {
        return $this->subject('Welcome to TANFORD Membership')
            ->view('emails.tanford_member_welcome');
    }
}

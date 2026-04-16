<?php

namespace App\Mail;

use App\Models\UaeResident;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UaeResidentUserConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public UaeResident $resident;

    public function __construct(UaeResident $resident)
    {
        $this->resident = $resident;
    }

    public function build(): self
    {
        return $this->subject('Your UAE resident registration has been received')
            ->view('emails.uae_resident_user_confirmation');
    }
}

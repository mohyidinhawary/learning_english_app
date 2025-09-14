<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;


class OtpEmail extends Mailable
{
    use Queueable, SerializesModels;


public $otp;
    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
$this->otp=$otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Your OTP Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content():Content
    {
return new Content(
    view:"emails.otp", with: [
                'otp' => $this->otp,  // تمرير otp إلى الـ view
            ]
);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [

        ];
    }
}

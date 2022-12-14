<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable {

    use Queueable, SerializesModels;

    private $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function envelope() {
        return new Envelope(
            subject: __("mail.subject"),
        );
    }

    public function content() {
        return new Content(
            view: "mail.verification",
            with: [
                "token" => $this->token,
            ],
        );
    }

    public function attachments() {
        return [];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $FullName;
    public string $password;

    public function __construct(string $FullName, string $password)
    {
        $this->FullName = $FullName;
        $this->password = $password;
    }


    public function content(): Content
    {
        return new Content(
            view: 'mail.send_password',
            with: [
                'FullName' => $this->FullName,
                'password' => $this->password,
            ]

        );
    }
}

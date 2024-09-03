<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificacaoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $data)
    {
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Verificação de Email',
        );
    }

    public function content()
    {
        return new Content(
            html: 'mails.verificacaoEmail',
        );
    }
}
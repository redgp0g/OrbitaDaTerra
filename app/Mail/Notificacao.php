<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Notificacao extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly array $data)
    {
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Notificação de Cadastro',
        );
    }

    public function content()
    {
        return new Content(
            html: 'mails.cadastro',
        );
    }
}

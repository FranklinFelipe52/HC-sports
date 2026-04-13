<?php

namespace App\Mail;

use App\Models\PrfRegistration;
use App\Models\PrfUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PrfConfirmRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public PrfUser $user;
    public PrfRegistration $registration;

    public function __construct(PrfUser $user, PrfRegistration $registration)
    {
        $this->user         = $user;
        $this->registration = $registration;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmação de Inscrição | Circuito Dunas',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Mails.PRF.ConfirmRegistration',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

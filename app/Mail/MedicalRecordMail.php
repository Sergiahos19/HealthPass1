<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class MedicalRecordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly string $pdf,
        private readonly string $patientName,
        private readonly string $filename,
        private readonly string $senderEmail,
        private readonly string $senderName,
        private readonly string $establishmentName = 'Votre établissement de santé',
    ) {}

    public function envelope(): Envelope
    {
        $fromAddress = config('mail.from.address', $this->senderEmail);
        $fromName = config('mail.from.name', $this->senderName);

        return new Envelope(
            from: new Address($fromAddress, $fromName),
            subject: 'Votre carnet médical - '.$this->establishmentName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.medical-record',
            text: 'emails.medical-record-text',
            with: [
                'patientName' => $this->patientName,
                'senderName' => $this->establishmentName,
                'senderEmail' => config('mail.from.address', $this->senderEmail),
            ],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn (): string => $this->pdf, $this->filename)
                ->withMime('application/pdf'),
        ];
    }
}

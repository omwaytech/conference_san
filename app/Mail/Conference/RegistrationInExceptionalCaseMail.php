<?php

namespace App\Mail\Conference;

use DomPDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationInExceptionalCaseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SANCON Conference Registration Mail',
        );
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.conference.registration-in-exceptioncase',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = DomPDF::loadView('emails.conference.payment-voucher', ['data' => $this->data])
            ->setPaper('legal', 'potrait');
        $pdfPath = storage_path('app/public/registration.pdf');
        $pdf->save($pdfPath);
        return [
            Attachment::fromPath($pdfPath)
                ->as('PaymentVoucher.pdf')
                ->withMime('application/pdf'),
        ];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentShareMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The documents to be shared
     *
     * @var array
     */
    public $documents;

    /**
     * Create a new message instance.
     *
     * @param array $documents
     * @return void
     */
    public function __construct(array $documents)
    {
        $this->documents = $documents;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Shared Documents for Your Review',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.document-share',
            with: [
                'documents' => $this->documents,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $filePath;

    /**
     * Create a new message instance.
     */
    public function __construct($request, $filePath = null)
    {
        $this->request = $request;
        $this->filePath = $filePath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->request['subject'], // Use subject from request
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail-template.welcome-mail',
            with: [
                'name' => $this->request['name'],
                'email' => $this->request['email'],
                'messageContent' => $this->request['message'],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachment = [];

        if ($this->filePath) {
            $fullPath = storage_path('app/public/' . $this->filePath);

            if (file_exists($fullPath)) {
                $attachment[] = Attachment::fromPath($fullPath);
            }
        }

        return $attachment;
    }
}

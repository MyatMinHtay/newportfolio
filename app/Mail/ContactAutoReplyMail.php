<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactAutoReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $contactMessage,
        public ?string $replyToEmail = null
    ) {}

    public function envelope(): Envelope
    {
        $siteName = (string) project('site_name', config('app.name', 'Portfolio'));
        $subject = 'Thank you for reaching out — ' . $siteName;

        $replyToList = [];
        if ($this->replyToEmail && filter_var($this->replyToEmail, FILTER_VALIDATE_EMAIL)) {
            $replyToList[] = new Address($this->replyToEmail, $siteName);
        }

        return new Envelope(
            subject: $subject,
            replyTo: $replyToList,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-auto-reply',
            with: [
                'siteName' => (string) project('site_name', config('app.name', 'Portfolio')),
                'siteUrl' => url('/'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

<?php

namespace App\Services;

use App\Mail\ContactAutoReplyMail;
use App\Mail\ContactInquiryMail;
use App\Models\ContactMessage;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EmailService
{
    /**
     * Send contact notification email synchronously to the configured recipient.
     * Logs failure without breaking contact submission.
     */
    public function sendContactNotification(ContactMessage $contactMessage): bool
    {
        $recipient = $this->resolveRecipient();

        if (empty($recipient)) {
            Log::warning('EmailService: Cannot send contact inquiry notification. No contact_email setting or admin user email found.', [
                'message_id' => $contactMessage->id,
            ]);

            return false;
        }

        try {
            Mail::to($recipient)->send(new ContactInquiryMail($contactMessage));

            return true;
        } catch (Throwable $e) {
            Log::error('EmailService: Failed to send contact inquiry notification email.', [
                'message_id' => $contactMessage->id,
                'recipient' => $recipient,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Send an auto-reply acknowledgment email synchronously to the visitor.
     * Logs failure without breaking contact submission.
     */
    public function sendVisitorAutoReply(ContactMessage $contactMessage): bool
    {
        $visitorEmail = trim((string) $contactMessage->email);

        if (empty($visitorEmail) || ! filter_var($visitorEmail, FILTER_VALIDATE_EMAIL)) {
            Log::warning('EmailService: Cannot send auto-reply to visitor. Invalid or empty visitor email.', [
                'message_id' => $contactMessage->id,
                'email' => $visitorEmail,
            ]);

            return false;
        }

        $ownerEmail = $this->resolveRecipient();

        try {
            Mail::to($visitorEmail)->send(new ContactAutoReplyMail($contactMessage, $ownerEmail));

            return true;
        } catch (Throwable $e) {
            Log::error('EmailService: Failed to send visitor auto-reply email.', [
                'message_id' => $contactMessage->id,
                'visitor_email' => $visitorEmail,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }


    /**
     * Resolve the recipient email address:
     * 1. Setting::get('contact_email')
     * 2. fallback -> admin user email
     *
     * Note: DO NOT use mail.from.address as recipient.
     */
    public function resolveRecipient(): ?string
    {
        $settingEmail = trim((string) Setting::get('contact_email'));

        if (! empty($settingEmail) && filter_var($settingEmail, FILTER_VALIDATE_EMAIL)) {
            return $settingEmail;
        }

        $adminEmail = User::query()
            ->where('is_admin', true)
            ->whereNotNull('email')
            ->value('email');

        if (! empty($adminEmail) && filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            return $adminEmail;
        }

        return null;
    }
}

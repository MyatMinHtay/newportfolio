<?php

namespace Tests\Feature;

use App\Mail\ContactInquiryMail;
use App\Models\ContactMessage;
use App\Models\Setting;
use App\Models\User;
use App\Services\EmailService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_stores_inquiry_and_sends_notification_mail(): void
    {
        Mail::fake();

        Setting::set('contact_email', 'owner@example.com');

        $payload = [
            'name' => 'Ko Aung',
            'email' => 'koaung@example.com',
            'subject' => 'New Web Project',
            'message' => 'I would like to hire you for a custom Laravel web system.',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        // 1. Stores inquiry in DB
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Ko Aung',
            'email' => 'koaung@example.com',
            'subject' => 'New Web Project',
            'message' => 'I would like to hire you for a custom Laravel web system.',
            'is_read' => false,
        ]);

        $message = ContactMessage::where('email', 'koaung@example.com')->first();
        $this->assertNotNull($message);

        // 2. Sends correct Mailable, correct recipient, and correct Reply-To
        Mail::assertSent(ContactInquiryMail::class, function (ContactInquiryMail $mail) use ($message) {
            $this->assertTrue($mail->hasTo('owner@example.com'));
            $this->assertTrue($mail->hasReplyTo('koaung@example.com', 'Ko Aung'));
            $this->assertSame($message->id, $mail->contactMessage->id);

            return true;
        });

        // 3. Sends auto-reply confirmation to the visitor
        Mail::assertSent(\App\Mail\ContactAutoReplyMail::class, function (\App\Mail\ContactAutoReplyMail $mail) use ($message) {
            $this->assertTrue($mail->hasTo('koaung@example.com'));
            $this->assertTrue($mail->hasReplyTo('owner@example.com'));
            $this->assertSame($message->id, $mail->contactMessage->id);

            return true;
        });
    }

    public function test_recipient_resolves_to_setting_or_fallback_admin_and_never_mail_from_address(): void
    {
        config(['mail.from.address' => 'system-noreply@example.com']);

        $service = new EmailService();

        // 1. When Setting is present
        Setting::set('contact_email', 'primary-contact@example.com');
        $this->assertSame('primary-contact@example.com', $service->resolveRecipient());

        // 2. When Setting is empty, fallback to admin user email
        Setting::set('contact_email', '');
        User::factory()->create([
            'email' => 'admin-user@example.com',
            'is_admin' => true,
        ]);

        $this->assertSame('admin-user@example.com', $service->resolveRecipient());

        // 3. When neither exists, returns null, NEVER mail.from.address
        User::query()->delete();
        Setting::set('contact_email', '');

        $this->assertNull($service->resolveRecipient());
        $this->assertNotSame('system-noreply@example.com', $service->resolveRecipient());
    }

    public function test_mailable_content_renders_details_and_admin_url_without_user_ip(): void
    {
        $contactMessage = ContactMessage::create([
            'name' => 'Daw Mya',
            'email' => 'dawmya@example.com',
            'subject' => 'Consultation Request',
            'message' => 'Need advice on cloud deployment.',
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 TestBrowser',
            'is_read' => false,
        ]);

        $mailable = new ContactInquiryMail($contactMessage);

        $html = $mailable->render();

        // Must see inquiry content
        $this->assertStringContainsString('Daw Mya', $html);
        $this->assertStringContainsString('dawmya@example.com', $html);
        $this->assertStringContainsString('Consultation Request', $html);
        $this->assertStringContainsString('Need advice on cloud deployment.', $html);

        // Must contain link to admin panel
        $this->assertStringContainsString(route('admin.messages.show', $contactMessage), $html);

        // Must NOT contain user IP in email body
        $this->assertStringNotContainsString('192.168.1.100', $html);
    }

    public function test_visitor_autoreply_content_renders_correctly_without_ip(): void
    {
        $contactMessage = ContactMessage::create([
            'name' => 'Ko Aung',
            'email' => 'koaung@example.com',
            'subject' => 'Website Redesign',
            'message' => 'Please provide a quotation for redesigning our website.',
            'ip_address' => '10.0.0.1',
            'user_agent' => 'Mozilla/5.0 Agent',
            'is_read' => false,
        ]);

        $mailable = new \App\Mail\ContactAutoReplyMail($contactMessage, 'owner@example.com');

        $html = $mailable->render();

        // Must address the visitor and summarize inquiry
        $this->assertStringContainsString('Ko Aung', $html);
        $this->assertStringContainsString('Website Redesign', $html);
        $this->assertStringContainsString('Please provide a quotation for redesigning our website.', $html);

        // Must NOT leak visitor IP address
        $this->assertStringNotContainsString('10.0.0.1', $html);

        // Envelope reply-to must point to owner
        $this->assertTrue($mailable->hasReplyTo('owner@example.com'));
    }

    public function test_mail_failure_does_not_fail_http_response_and_still_saves_record(): void
    {
        // Mock Mail facade to simulate mail exception
        Mail::shouldReceive('to')
            ->andThrow(new Exception('Gmail SMTP connection timed out.'));

        Setting::set('contact_email', 'owner@example.com');

        $payload = [
            'name' => 'Failing Mail Test',
            'email' => 'fail@example.com',
            'subject' => 'SMTP Timeout Test',
            'message' => 'This message should still be saved even if Gmail SMTP fails.',
        ];

        $response = $this->postJson('/contact', $payload);

        // HTTP response must still be 200 OK
        $response->assertOk()
            ->assertJson([
                'success' => true,
            ]);

        // DB record must still be saved
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Failing Mail Test',
            'email' => 'fail@example.com',
            'subject' => 'SMTP Timeout Test',
        ]);
    }
}


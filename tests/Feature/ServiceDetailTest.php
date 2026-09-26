<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceDetailTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_can_create_service_with_markdown_details(): void
    {
        $detailsMarkdown = <<<'MD'
### Deliverables
- **Custom Workflow**: Connect CRM with Telegram.
- **Webhook Integration**: Realtime alerts.
MD;

        $response = $this->actingAs($this->admin())->post(route('admin.services.store'), [
            'title' => 'n8n Automation Service',
            'summary' => 'Visual workflow automations for enterprise.',
            'details' => $detailsMarkdown,
            'icon' => 'bi-gear-wide-connected',
            'sort_order' => 1,
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', [
            'title' => 'n8n Automation Service',
            'icon' => 'bi-gear-wide-connected',
        ]);

        $service = Service::where('title', 'n8n Automation Service')->first();
        $this->assertNotNull($service);
        $this->assertSame($detailsMarkdown, $service->details);
        $this->assertStringContainsString('<h3>Deliverables</h3>', $service->renderedDetails());
        $this->assertCount(2, $service->highlights());
        $this->assertStringContainsString('Custom Workflow', $service->highlights()[0]);
    }

    public function test_admin_can_update_service_details(): void
    {
        $service = Service::create([
            'title' => 'MMQR Payment Integration',
            'summary' => 'KBZPay and WavePay checkout integration.',
            'details' => '- **Feature 1**: Dynamic QR.',
            'icon' => 'bi-qr-code-scan',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $updatedDetails = <<<'MD'
### What We Offer
- **MMQR Dynamic**: Instant bank scanning.
- **Slip Uploads**: Manual verification workflow.
MD;

        $response = $this->actingAs($this->admin())->put(route('admin.services.update', $service), [
            'title' => 'MMQR Payment Integration (Enhanced)',
            'summary' => 'Updated payment summary.',
            'details' => $updatedDetails,
            'icon' => 'bi-qr-code-scan',
            'sort_order' => 2,
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $service->refresh();
        $this->assertSame('MMQR Payment Integration (Enhanced)', $service->title);
        $this->assertSame($updatedDetails, $service->details);
    }

    public function test_homepage_displays_services_and_modal_dialogs(): void
    {
        $service = Service::create([
            'title' => 'Telegram Bot Development',
            'summary' => 'Automated bots for notifications and transactions.',
            'details' => <<<'MD'
### Core Deliverables
- **Live Notifications**: Group alerts.
- **Payment Verification**: Slip checking.
MD,
            'icon' => 'bi-telegram',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Telegram Bot Development');
        $response->assertSee('Automated bots for notifications and transactions.');
        $response->assertSee('data-bs-target="#serviceModal'.$service->id.'"', false);
        $response->assertSee('id="serviceModal'.$service->id.'"', false);
        $response->assertSee('Live Notifications', false);
        $response->assertSee('Payment Verification', false);
        $response->assertSee('data-service-title="Telegram Bot Development"', false);
    }

    public function test_hidden_service_does_not_appear_on_homepage(): void
    {
        Service::create([
            'title' => 'Unpublished Service',
            'summary' => 'Hidden from visitors.',
            'details' => 'Secret details.',
            'icon' => 'bi-lock',
            'sort_order' => 10,
            'is_published' => false,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertDontSee('Unpublished Service');
    }
}

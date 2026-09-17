<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_homepage_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Myat Min Htay');
        $response->assertSee('Production &amp; Freelance Projects', false);
        $response->assertSee('Technical Skills');
        $response->assertSee('Services');
        $response->assertSee('Experience &amp; Milestones', false);
        $response->assertSee('Laravel Socialite');
        $response->assertSee('Linux Basic');
        $response->assertDontSee('Vue.js');
        $response->assertDontSee('Angular');
        $response->assertDontSee('Nexus VPN Panel');
    }

    public function test_contact_form_stores_message_successfully(): void
    {
        $payload = [
            'name' => 'Alice Test',
            'email' => 'alice@example.com',
            'subject' => 'Project Collaboration',
            'message' => 'Hello, I would like to discuss a web application project.',
        ];

        $response = $this->postJson('/contact', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Alice Test',
            'email' => 'alice@example.com',
            'subject' => 'Project Collaboration',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->postJson('/contact', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'message']);
    }
}

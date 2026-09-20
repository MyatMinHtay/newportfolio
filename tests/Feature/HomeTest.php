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
        $response->assertSee('Nexus VPN Panel');
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

    public function test_experience_markdown_list_is_rendered_on_homepage(): void
    {
        \App\Models\Experience::create([
            'company' => 'Qualy Myanmar',
            'role' => 'Frontend Engineer',
            'start_date' => '2024-09-01',
            'description' => "- Developed interfaces using **HTML, CSS, JavaScript**.\n- Built **WordPress websites**.",
            'is_published' => true,
            'sort_order' => 0,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Frontend Engineer');
        $response->assertSee('Qualy Myanmar');
        $response->assertSee('<ul>', false);
        $response->assertSee('<strong>HTML, CSS, JavaScript</strong>', false);
        $response->assertSee('<strong>WordPress websites</strong>', false);
    }
}

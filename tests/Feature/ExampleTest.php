<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_ui_preview_returns_successful_response(): void
    {
        $response = $this->get('/ui-preview');

        $response->assertStatus(200);
        $response->assertSee('Visualize Your');
        $response->assertSee('Why Realtime Colors?');
        $response->assertSee('Plans & Pricing');
    }
}

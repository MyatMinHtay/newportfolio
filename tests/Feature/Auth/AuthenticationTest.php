<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Sign In');
    }

    public function test_admin_user_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin.home'));
    }

    public function test_user_cannot_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_unauthenticated_user_is_redirected_from_admin(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_non_admin_user_is_forbidden_from_admin(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Case Studies');
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}

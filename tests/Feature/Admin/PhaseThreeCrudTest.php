<?php

namespace Tests\Feature\Admin;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhaseThreeCrudTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'is_admin' => true,
        ]);
    }

    public function test_guest_cannot_access_phase_three_admin_routes(): void
    {
        $this->get(route('admin.messages.index'))->assertRedirect('/login');
        $this->get(route('admin.categories.index'))->assertRedirect('/login');
        $this->get(route('admin.posts.index'))->assertRedirect('/login');
    }

    public function test_admin_can_view_and_manage_contact_messages(): void
    {
        $admin = $this->admin();

        $message = ContactMessage::create([
            'name' => 'John Client',
            'email' => 'client@example.com',
            'subject' => 'Project Inquiry',
            'message' => 'Need a Laravel system built.',
            'is_read' => false,
        ]);

        // 1. Index
        $response = $this->actingAs($admin)->get(route('admin.messages.index'));
        $response->assertOk();
        $response->assertSee('John Client');
        $response->assertSee('Project Inquiry');

        // 2. Show auto marks as read
        $this->actingAs($admin)->get(route('admin.messages.show', $message))->assertOk();
        $this->assertTrue($message->fresh()->is_read);

        // 3. Toggle read status back to unread
        $this->actingAs($admin)->post(route('admin.messages.toggle-read', $message))
            ->assertRedirect();
        $this->assertFalse($message->fresh()->is_read);

        // 4. Delete message
        $this->actingAs($admin)->delete(route('admin.messages.destroy', $message))
            ->assertRedirect(route('admin.messages.index'));
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_admin_can_create_update_and_delete_category(): void
    {
        $admin = $this->admin();

        // 1. Create
        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'DevOps & Linux',
            'slug' => 'devops-linux',
        ]);
        $response->assertRedirect(route('admin.categories.index'));

        $category = Category::where('slug', 'devops-linux')->first();
        $this->assertNotNull($category);

        // 2. Update
        $this->actingAs($admin)->put(route('admin.categories.update', $category), [
            'name' => 'Cloud & DevOps',
            'slug' => 'cloud-devops',
        ])->assertRedirect(route('admin.categories.index'));

        $category->refresh();
        $this->assertSame('Cloud & DevOps', $category->name);

        // 3. Delete
        $this->actingAs($admin)->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_can_create_update_and_delete_blog_post(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $category = Category::create([
            'name' => 'Laravel Insights',
            'slug' => 'laravel-insights',
        ]);

        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
        $cover = UploadedFile::fake()->createWithContent('article.png', $png);

        // 1. Create
        $response = $this->actingAs($admin)->post(route('admin.posts.store'), [
            'title' => 'Building High-Performance Laravel APIs',
            'slug' => 'building-high-performance-laravel-apis',
            'category_id' => $category->id,
            'excerpt' => 'A guide on optimizing MySQL queries and caching.',
            'body' => "## Architecture\n\nTips on reducing response times.",
            'cover_image' => $cover,
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.posts.index'));
        $post = BlogPost::where('slug', 'building-high-performance-laravel-apis')->first();
        $this->assertNotNull($post);
        $this->assertTrue($post->is_published);
        $this->assertNotNull($post->published_at);
        $this->assertNotNull($post->cover_image);
        Storage::disk('public')->assertExists($post->cover_image);

        // 2. Update
        $this->actingAs($admin)->put(route('admin.posts.update', $post), [
            'title' => 'Building High-Performance Laravel APIs — Updated',
            'slug' => 'building-high-performance-laravel-apis',
            'category_id' => $category->id,
            'excerpt' => 'Updated guide.',
            'body' => '## Updated Architecture',
            'is_published' => '0',
        ])->assertRedirect(route('admin.posts.index'));

        $this->assertSame('Building High-Performance Laravel APIs — Updated', $post->fresh()->title);
        $this->assertFalse($post->fresh()->is_published);

        // 3. Delete (soft delete)
        $this->actingAs($admin)->delete(route('admin.posts.destroy', $post))
            ->assertRedirect(route('admin.posts.index'));
        $this->assertSoftDeleted('blog_posts', ['id' => $post->id]);
    }
}

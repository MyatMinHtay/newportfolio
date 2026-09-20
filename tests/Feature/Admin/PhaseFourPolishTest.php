<?php

namespace Tests\Feature\Admin;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhaseFourPolishTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'is_admin' => true,
        ]);
    }

    private function fakePng(string $filename = 'test.png'): UploadedFile
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');

        return UploadedFile::fake()->createWithContent($filename, $png);
    }

    public function test_admin_can_toggle_project_published_status(): void
    {
        $project = Project::create([
            'title' => 'Toggle Project',
            'slug' => 'toggle-project',
            'summary' => 'Summary',
            'body' => 'Body',
            'is_published' => false,
        ]);

        $response = $this->actingAs($this->admin())
            ->post(route('admin.projects.toggle-publish', $project));

        $response->assertSessionHas('toast_success');
        $this->assertTrue($project->fresh()->is_published);

        // Toggle back
        $this->actingAs($this->admin())
            ->post(route('admin.projects.toggle-publish', $project));

        $this->assertFalse($project->fresh()->is_published);
    }

    public function test_admin_can_toggle_project_featured_status(): void
    {
        $project = Project::create([
            'title' => 'Featured Toggle Project',
            'slug' => 'featured-toggle-project',
            'summary' => 'Summary',
            'body' => 'Body',
            'is_featured' => false,
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->admin())
            ->post(route('admin.projects.toggle-featured', $project));

        $response->assertSessionHas('toast_success');
        $this->assertTrue($project->fresh()->is_featured);

        // Toggle back
        $this->actingAs($this->admin())
            ->post(route('admin.projects.toggle-featured', $project));

        $this->assertFalse($project->fresh()->is_featured);
    }

    public function test_admin_can_toggle_blog_post_published_status(): void
    {
        $user = $this->admin();
        $post = BlogPost::create([
            'user_id' => $user->id,
            'title' => 'Blog Toggle Post',
            'slug' => 'blog-toggle-post',
            'body' => 'Post Body',
            'is_published' => false,
            'published_at' => null,
        ]);

        $response = $this->actingAs($user)
            ->post(route('admin.posts.toggle-publish', $post));

        $response->assertSessionHas('toast_success');
        $this->assertTrue($post->fresh()->is_published);
        $this->assertNotNull($post->fresh()->published_at);

        // Toggle back
        $this->actingAs($user)
            ->post(route('admin.posts.toggle-publish', $post));

        $this->assertFalse($post->fresh()->is_published);
    }

    public function test_guest_cannot_toggle_project_or_post_status(): void
    {
        $user = User::factory()->create();
        $project = Project::create([
            'title' => 'Protected Project',
            'slug' => 'protected-project',
            'summary' => 'Summary',
            'body' => 'Body',
            'is_published' => false,
        ]);
        $post = BlogPost::create([
            'user_id' => $user->id,
            'title' => 'Protected Post',
            'slug' => 'protected-post',
            'body' => 'Body',
            'is_published' => false,
        ]);

        $this->post(route('admin.projects.toggle-publish', $project))->assertRedirect('/login');
        $this->post(route('admin.projects.toggle-featured', $project))->assertRedirect('/login');
        $this->post(route('admin.posts.toggle-publish', $post))->assertRedirect('/login');

        $this->assertFalse($project->fresh()->is_published);
        $this->assertFalse($post->fresh()->is_published);
    }

    public function test_admin_can_filter_projects_by_status(): void
    {
        Project::create([
            'title' => 'Published Project',
            'slug' => 'published-project',
            'summary' => 'Summary',
            'body' => 'Body',
            'is_published' => true,
        ]);
        Project::create([
            'title' => 'Hidden Project',
            'slug' => 'hidden-project',
            'summary' => 'Summary',
            'body' => 'Body',
            'is_published' => false,
        ]);

        $response = $this->actingAs($this->admin())
            ->get(route('admin.projects.index', ['status' => 'published']));

        $response->assertOk();
        $response->assertSee('Published Project');
        $response->assertDontSee('Hidden Project');

        $hiddenResponse = $this->actingAs($this->admin())
            ->get(route('admin.projects.index', ['status' => 'hidden']));

        $hiddenResponse->assertOk();
        $hiddenResponse->assertSee('Hidden Project');
        $hiddenResponse->assertDontSee('Published Project');
    }

    public function test_admin_can_filter_posts_by_status(): void
    {
        $user = $this->admin();
        BlogPost::create([
            'user_id' => $user->id,
            'title' => 'Live Post Alpha',
            'slug' => 'live-post-alpha',
            'body' => 'Body',
            'is_published' => true,
        ]);
        BlogPost::create([
            'user_id' => $user->id,
            'title' => 'Draft Post Beta',
            'slug' => 'draft-post-beta',
            'body' => 'Body',
            'is_published' => false,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.posts.index', ['status' => 'published']));

        $response->assertOk();
        $response->assertSee('Live Post Alpha');
        $response->assertDontSee('Draft Post Beta');

        $draftResponse = $this->actingAs($user)
            ->get(route('admin.posts.index', ['status' => 'draft']));

        $draftResponse->assertOk();
        $draftResponse->assertSee('Draft Post Beta');
        $draftResponse->assertDontSee('Live Post Alpha');
    }

    public function test_updating_project_cover_image_deletes_old_image(): void
    {
        Storage::fake('public');

        $oldImage = $this->fakePng('old_cover.png');
        $oldPath = $oldImage->store('projects/covers', 'public');

        $project = Project::create([
            'title' => 'Image Project',
            'slug' => 'image-project',
            'summary' => 'Summary',
            'body' => 'Body',
            'cover_image' => $oldPath,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        $newImage = $this->fakePng('new_cover.png');

        $this->actingAs($this->admin())->put(route('admin.projects.update', $project), [
            'title' => $project->title,
            'summary' => $project->summary,
            'body' => $project->body,
            'cover_image' => $newImage,
        ]);

        Storage::disk('public')->assertMissing($oldPath);
        $this->assertNotNull($project->fresh()->cover_image);
        Storage::disk('public')->assertExists($project->fresh()->cover_image);
    }

    public function test_admin_dashboard_displays_enhanced_stats_and_activity(): void
    {
        $user = $this->admin();

        for ($i = 1; $i <= 3; $i++) {
            Project::create([
                'title' => "Project {$i}",
                'slug' => "project-{$i}",
                'summary' => 'Summary',
                'body' => 'Body',
                'is_published' => true,
                'is_featured' => true,
            ]);
        }

        BlogPost::create([
            'user_id' => $user->id,
            'title' => 'Dashboard Post',
            'slug' => 'dashboard-post',
            'body' => 'Body',
            'is_published' => true,
        ]);

        ContactMessage::create([
            'name' => 'Alice Client',
            'email' => 'alice@example.com',
            'subject' => 'Website Inquiry',
            'message' => 'Hello there',
            'is_read' => false,
        ]);

        Resume::create([
            'title' => 'Senior Laravel Resume',
            'file_path' => 'resumes/resume.pdf',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('admin.home'));

        $response->assertOk();
        $response->assertSee('Senior Laravel Resume');
        $response->assertSee('Alice Client');
        $response->assertSee('Website Inquiry');
        $response->assertSee('3 Published');
        $response->assertSee('3 Featured');
    }

    public function test_admin_messages_and_pages_render_with_mobile_responsive_views(): void
    {
        $user = $this->admin();

        $msg = ContactMessage::create([
            'name' => 'Ko Aung Mobile Test',
            'email' => 'koaung.mobile@example.com',
            'subject' => 'Mobile Inquiry Test',
            'message' => 'Checking mobile responsive layout.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)->get(route('admin.messages.index'));

        $response->assertOk();
        // Verify mobile view classes are rendered
        $response->assertSee('pf-mobile-card-item');
        $response->assertSee('d-md-none');
        $response->assertSee('d-none d-md-block');
        $response->assertSee('Ko Aung Mobile Test');
        $response->assertSee('koaung.mobile@example.com');
        $response->assertSee('Mobile Inquiry Test');

        // Check single message view
        $showResponse = $this->actingAs($user)->get(route('admin.messages.show', $msg));
        $showResponse->assertOk();
        $showResponse->assertSee('Ko Aung Mobile Test');

        // Check topbar no longer prints placeholder text
        $response->assertDontSee('Top navigation placeholder');
    }
}


<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_published_project_case_study(): void
    {
        $project = Project::create([
            'title' => 'MorningStar Translation MM',
            'slug' => 'morningstar-translation-mm',
            'summary' => 'Reading platform for Myanmar webtoons.',
            'body' => "## Architecture\n\nBuilt with Laravel and queues.",
            'tech_stack' => ['Laravel', 'MySQL'],
            'is_published' => true,
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        $response = $this->get(route('projects.show', $project));
        $response->assertOk();
        $response->assertSee('MorningStar Translation MM');
        $response->assertSee('Built with Laravel and queues.');
        $response->assertSee('<h2>Architecture</h2>', false);
    }

    public function test_cannot_view_unpublished_project_as_guest(): void
    {
        $project = Project::create([
            'title' => 'Unpublished Work',
            'slug' => 'unpublished-work',
            'summary' => 'Secret project.',
            'body' => 'Secret body',
            'is_published' => false,
            'sort_order' => 10,
        ]);

        $this->get(route('projects.show', $project))->assertNotFound();

        // Admin can preview unpublished project
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)->get(route('projects.show', $project))->assertOk();
    }

    public function test_can_view_public_blog_index_and_post(): void
    {
        $category = Category::create([
            'name' => 'Backend Engineering',
            'slug' => 'backend-engineering',
        ]);

        $post = BlogPost::create([
            'title' => 'Optimizing Eloquent Queries in Production',
            'slug' => 'optimizing-eloquent-queries',
            'category_id' => $category->id,
            'excerpt' => 'Practical tips on eager loading.',
            'body' => "## Eager Loading\n\nAlways use `with()` to prevent N+1 queries.",
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        // Blog index
        $indexResponse = $this->get(route('blog.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('Optimizing Eloquent Queries in Production');
        $indexResponse->assertSee('Backend Engineering');

        // Filter by category
        $filteredResponse = $this->get(route('blog.index', ['category' => 'backend-engineering']));
        $filteredResponse->assertOk();
        $filteredResponse->assertSee('Optimizing Eloquent Queries in Production');

        // Single Post
        $postResponse = $this->get(route('blog.show', $post));
        $postResponse->assertOk();
        $postResponse->assertSee('Always use <code>with()</code> to prevent N+1 queries.', false);
    }

    public function test_cannot_view_draft_blog_post_as_guest(): void
    {
        $post = BlogPost::create([
            'title' => 'Draft Post',
            'slug' => 'draft-post',
            'body' => 'Draft body',
            'is_published' => false,
        ]);

        $this->get(route('blog.show', $post))->assertNotFound();

        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)->get(route('blog.show', $post))->assertOk();
    }
}

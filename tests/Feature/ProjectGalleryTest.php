<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Database\Seeders\CurrentWorkSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectGalleryTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'is_admin' => true,
        ]);
    }

    private function fakePng(string $name = 'image.png', int $kb = 10): UploadedFile
    {
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
        if ($kb > 10) {
            $png .= str_repeat('A', ($kb - 1) * 1024);
        }

        return UploadedFile::fake()->createWithContent($name, $png);
    }

    public function test_skills_seeder_contains_n8n_and_rest_api_idempotently(): void
    {
        $seeder = new CurrentWorkSeeder();
        $seeder->run();

        $n8n = Skill::query()->where('name', 'n8n')->first();
        $this->assertNotNull($n8n);
        $this->assertSame('Tools', $n8n->category);
        $this->assertSame(4, $n8n->proficiency);
        $this->assertTrue($n8n->is_published);

        $rest = Skill::query()->where('name', 'REST API')->first();
        $this->assertNotNull($rest);
        $this->assertSame('Backend', $rest->category);
        $this->assertSame(5, $rest->proficiency);
        $this->assertTrue($rest->is_published);

        // Run second time to verify idempotency
        $seeder->run();
        $this->assertSame(1, Skill::query()->where('name', 'n8n')->count());
        $this->assertSame(1, Skill::query()->where('name', 'REST API')->count());
    }

    public function test_admin_can_upload_gallery_images_on_create(): void
    {
        Storage::fake('public');

        $file1 = $this->fakePng('screenshot1.png');
        $file2 = $this->fakePng('screenshot2.png');

        $response = $this->actingAs($this->admin())->post(route('admin.projects.store'), [
            'title' => 'Gallery Test Project',
            'summary' => 'A project with gallery screenshots.',
            'body' => '## Case study body',
            'is_published' => '1',
            'gallery_images' => [$file1, $file2],
        ]);

        $project = Project::query()->where('title', 'Gallery Test Project')->first();
        $this->assertNotNull($project);
        $response->assertRedirect(route('admin.projects.edit', $project));

        $this->assertTrue($project->hasGallery());
        $this->assertIsArray($project->gallery);
        $this->assertCount(2, $project->gallery);

        // Verify only relative paths are stored in database
        foreach ($project->gallery as $path) {
            $this->assertStringStartsWith('projects/gallery/', $path);
            $this->assertStringNotContainsString('http://', $path);
            $this->assertStringNotContainsString('https://', $path);
            Storage::disk('public')->assertExists($path);
        }

        // Verify dynamic URL resolution
        $urls = $project->gallery_urls;
        $this->assertCount(2, $urls);
        foreach ($urls as $url) {
            $this->assertStringContainsString('/storage/projects/gallery/', $url);
        }
    }

    public function test_gallery_validation_enforces_image_type_size_and_count(): void
    {
        Storage::fake('public');

        // Test non-image file rejected
        $badFile = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');
        $response = $this->actingAs($this->admin())->post(route('admin.projects.store'), [
            'title' => 'Invalid Gallery File',
            'summary' => 'Testing invalid mime.',
            'gallery_images' => [$badFile],
        ]);
        $response->assertSessionHasErrors('gallery_images.0');

        // Test file exceeding 5MB (5120KB) rejected
        $largeFile = $this->fakePng('large.png', 5200);
        $response = $this->actingAs($this->admin())->post(route('admin.projects.store'), [
            'title' => 'Large Gallery File',
            'summary' => 'Testing file size.',
            'gallery_images' => [$largeFile],
        ]);
        $response->assertSessionHasErrors('gallery_images.0');

        // Test more than 10 images rejected
        $elevenImages = [];
        for ($i = 0; $i < 11; $i++) {
            $elevenImages[] = $this->fakePng("img_{$i}.png");
        }
        $response = $this->actingAs($this->admin())->post(route('admin.projects.store'), [
            'title' => 'Too Many Images',
            'summary' => 'Testing count limit.',
            'gallery_images' => $elevenImages,
        ]);
        $response->assertSessionHasErrors('gallery_images');
    }

    public function test_admin_can_safely_remove_gallery_images_and_ignores_arbitrary_paths(): void
    {
        Storage::fake('public');

        $path1 = 'projects/gallery/sample-image-1.png';
        $path2 = 'projects/gallery/sample-image-2.png';
        $foreignPath = 'projects/gallery/system-critical-file.txt';

        Storage::disk('public')->put($path1, 'dummy-image-1');
        Storage::disk('public')->put($path2, 'dummy-image-2');
        Storage::disk('public')->put($foreignPath, 'critical-data');

        $project = Project::create([
            'title' => 'Existing Gallery Project',
            'slug' => 'existing-gallery-project',
            'summary' => 'Testing deletion.',
            'gallery' => [$path1, $path2],
            'is_published' => true,
        ]);

        // Request removal of $path1 and $foreignPath
        $response = $this->actingAs($this->admin())->put(route('admin.projects.update', $project), [
            'title' => 'Existing Gallery Project Updated',
            'summary' => 'Testing deletion.',
            'remove_gallery' => [$path1, $foreignPath],
        ]);

        $project->refresh();
        $response->assertRedirect(route('admin.projects.edit', $project));

        // Path 1 should be deleted from storage and removed from project
        Storage::disk('public')->assertMissing($path1);
        $this->assertSame([$path2], $project->gallery);

        // Path 2 should remain intact
        Storage::disk('public')->assertExists($path2);

        // Foreign path MUST NOT be deleted (deletion safety verification)
        Storage::disk('public')->assertExists($foreignPath);
    }

    public function test_destroying_project_cleans_up_gallery_images(): void
    {
        Storage::fake('public');

        $path = 'projects/gallery/project-to-delete.png';
        Storage::disk('public')->put($path, 'dummy-image');

        $project = Project::create([
            'title' => 'Project To Delete',
            'slug' => 'project-to-delete',
            'summary' => 'Testing destroy cleanup.',
            'gallery' => [$path],
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->admin())->delete(route('admin.projects.destroy', $project));
        $response->assertRedirect(route('admin.projects.index'));

        Storage::disk('public')->assertMissing($path);
    }

    public function test_public_case_study_renders_gallery_showcase_and_modal(): void
    {
        $project = Project::create([
            'title' => 'Showcase Project',
            'slug' => 'showcase-project',
            'summary' => 'Testing public gallery rendering.',
            'body' => '## Body text',
            'gallery' => ['assets/img/projects/thumbnail1.png'],
            'is_published' => true,
        ]);

        $response = $this->get(route('projects.show', $project));
        $response->assertOk();
        $response->assertSee('Media &amp; Screenshots', false);
        $response->assertSee('id="projectGalleryModal"', false);
    }

    public function test_blog_index_renders_pagination_component(): void
    {
        $category = Category::create([
            'name' => 'Backend',
            'slug' => 'backend',
        ]);

        BlogPost::create([
            'title' => 'Test Post',
            'slug' => 'test-post',
            'category_id' => $category->id,
            'summary' => 'Summary of post',
            'body' => 'Post body text',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get(route('blog.index'));
        $response->assertOk();
        $response->assertSee('Articles &amp; Developer Notes', false);
    }
}

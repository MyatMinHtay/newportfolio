<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentCrudTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'is_admin' => true,
        ]);
    }

    public function test_guest_cannot_view_admin_case_studies(): void
    {
        $this->get(route('admin.projects.index'))->assertRedirect('/login');
    }

    public function test_admin_can_create_a_case_study(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.projects.store'), [
            'title' => 'Sample Case Study',
            'summary' => 'A short summary of the work.',
            'body' => '## Overview',
            'tech_stack' => 'Laravel 12, MySQL',
            'is_published' => '1',
        ]);

        $project = Project::query()->where('title', 'Sample Case Study')->first();

        $this->assertNotNull($project);
        $this->assertSame('sample-case-study', $project->slug);
        $this->assertSame(['Laravel 12', 'MySQL'], $project->tech_stack);
        $response->assertRedirect(route('admin.projects.edit', $project));
        $response->assertSessionHas('toast_success');
    }

    public function test_admin_can_upload_a_skill_icon_on_create(): void
    {
        Storage::fake('public');

        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');

        $response = $this->actingAs($this->admin())->post(route('admin.skills.store'), [
            'name' => 'Linux Basic',
            'category' => 'Tools',
            'proficiency' => 3,
            'sort_order' => 5,
            'icon' => UploadedFile::fake()->createWithContent('linux.png', $png),
            'is_published' => '1',
        ]);

        $skill = Skill::query()->where('name', 'Linux Basic')->first();

        $this->assertNotNull($skill);
        $this->assertNotNull($skill->icon_path);
        Storage::disk('public')->assertExists($skill->icon_path);
        $response->assertRedirect(route('admin.skills.index'));
    }

    public function test_admin_can_create_a_service(): void
    {
        $response = $this->actingAs($this->admin())->post(route('admin.services.store'), [
            'title' => 'Laravel web applications',
            'summary' => 'Custom Laravel products and admin tools.',
            'icon' => 'bi-layers',
            'sort_order' => 1,
            'is_published' => '1',
        ]);

        $this->assertDatabaseHas('services', [
            'title' => 'Laravel web applications',
            'icon' => 'bi-layers',
            'is_published' => 1,
        ]);
        $response->assertRedirect(route('admin.services.index'));
    }

    public function test_admin_can_unpublish_a_project(): void
    {
        $project = Project::query()->create([
            'title' => 'Hidden Work',
            'slug' => 'hidden-work',
            'summary' => 'Not on the homepage yet.',
            'is_published' => true,
            'is_featured' => true,
            'sort_order' => 9,
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.projects.update', $project), [
                'title' => 'Hidden Work',
                'slug' => 'hidden-work',
                'summary' => 'Not on the homepage yet.',
            ])
            ->assertRedirect();

        $this->assertFalse($project->fresh()->is_published);
        $this->assertFalse($project->fresh()->is_featured);
    }
}

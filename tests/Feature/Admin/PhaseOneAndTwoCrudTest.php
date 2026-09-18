<?php

namespace Tests\Feature\Admin;

use App\Models\Experience;
use App\Models\Resume;
use App\Models\Setting;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhaseOneAndTwoCrudTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'is_admin' => true,
        ]);
    }

    public function test_guest_cannot_access_phase_one_and_two_routes(): void
    {
        $this->get(route('admin.settings.index'))->assertRedirect('/login');
        $this->get(route('admin.social-links.index'))->assertRedirect('/login');
        $this->get(route('admin.experiences.index'))->assertRedirect('/login');
        $this->get(route('admin.resumes.index'))->assertRedirect('/login');
    }

    public function test_admin_can_update_settings(): void
    {
        $response = $this->actingAs($this->admin())->put(route('admin.settings.update'), [
            'site_name' => 'Myat Min Htay',
            'site_title' => 'Myat Min Htay — Portfolio CMS',
            'hero_title' => 'Lead Laravel Developer',
            'hero_subtitle' => 'Building enterprise web systems and cloud infrastructure.',
            'about_bio' => 'Passionate software engineer since 2018.',
            'contact_email' => 'contact@myatminhtay.com',
            'contact_phone' => '09266216485',
            'contact_location' => 'Mandalay, Myanmar',
            'freelance_status' => 'Available for Consulting',
            'birthday' => '2001-12-06',
            'education' => 'B.Sc Physics',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $response->assertSessionHas('toast_success');

        $this->assertSame('Lead Laravel Developer', Setting::get('hero_title'));
        $this->assertSame('contact@myatminhtay.com', Setting::get('contact_email'));
    }

    public function test_admin_can_create_update_and_delete_social_link(): void
    {
        $admin = $this->admin();

        // 1. Create
        $response = $this->actingAs($admin)->post(route('admin.social-links.store'), [
            'label' => 'LinkedIn',
            'url' => 'https://linkedin.com/in/myatminhtay',
            'icon' => 'bi-linkedin',
            'sort_order' => 1,
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.social-links.index'));
        $social = SocialLink::where('label', 'LinkedIn')->first();
        $this->assertNotNull($social);
        $this->assertTrue($social->is_published);

        // 2. Update
        $this->actingAs($admin)->put(route('admin.social-links.update', $social), [
            'label' => 'LinkedIn Pro',
            'url' => 'https://linkedin.com/in/myatminhtay',
            'icon' => 'bi-linkedin',
            'sort_order' => 2,
            'is_published' => '0',
        ])->assertRedirect(route('admin.social-links.index'));

        $this->assertSame('LinkedIn Pro', $social->fresh()->label);
        $this->assertFalse($social->fresh()->is_published);

        // 3. Delete
        $this->actingAs($admin)->delete(route('admin.social-links.destroy', $social))
            ->assertRedirect(route('admin.social-links.index'));
        $this->assertDatabaseMissing('social_links', ['id' => $social->id]);
    }

    public function test_admin_can_create_update_and_delete_experience(): void
    {
        $admin = $this->admin();

        // 1. Create
        $response = $this->actingAs($admin)->post(route('admin.experiences.store'), [
            'company' => 'MorningStar MM',
            'role' => 'Senior Backend Engineer',
            'location' => 'Remote / Mandalay',
            'start_date' => '2024-01-01',
            'end_date' => null,
            'description' => 'Architected reading platform and Telegram billing.',
            'sort_order' => 1,
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.experiences.index'));
        $exp = Experience::where('company', 'MorningStar MM')->first();
        $this->assertNotNull($exp);
        $this->assertNull($exp->end_date);
        $this->assertTrue($exp->is_published);

        // 2. Update
        $this->actingAs($admin)->put(route('admin.experiences.update', $exp), [
            'company' => 'MorningStar MM',
            'role' => 'Principal Engineer',
            'location' => 'Remote',
            'start_date' => '2024-01-01',
            'end_date' => '2025-12-31',
            'description' => 'Updated responsibilities.',
            'sort_order' => 2,
            'is_published' => '1',
        ])->assertRedirect(route('admin.experiences.index'));

        $this->assertSame('Principal Engineer', $exp->fresh()->role);

        // 3. Delete (soft deletes)
        $this->actingAs($admin)->delete(route('admin.experiences.destroy', $exp))
            ->assertRedirect(route('admin.experiences.index'));
        $this->assertSoftDeleted('experiences', ['id' => $exp->id]);
    }

    public function test_admin_can_upload_resume_and_activate_it(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $pdf = UploadedFile::fake()->create('cv_2026.pdf', 100, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('admin.resumes.store'), [
            'title' => 'Software Engineer CV',
            'resume_file' => $pdf,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.resumes.index'));
        $resume = Resume::where('title', 'Software Engineer CV')->first();
        $this->assertNotNull($resume);
        $this->assertTrue($resume->is_active);
        Storage::disk('public')->assertExists($resume->file_path);

        // Upload a second resume without activate
        $pdf2 = UploadedFile::fake()->create('cv_draft.pdf', 100, 'application/pdf');
        $this->actingAs($admin)->post(route('admin.resumes.store'), [
            'title' => 'Draft CV',
            'resume_file' => $pdf2,
            'is_active' => '0',
        ]);

        $resume2 = Resume::where('title', 'Draft CV')->first();
        $this->assertNotNull($resume2);
        $this->assertFalse($resume2->is_active);
        $this->assertTrue($resume->fresh()->is_active);

        // Activate second resume
        $this->actingAs($admin)->post(route('admin.resumes.activate', $resume2))
            ->assertRedirect(route('admin.resumes.index'));

        $this->assertTrue($resume2->fresh()->is_active);
        $this->assertFalse($resume->fresh()->is_active);

        // Delete resume
        $this->actingAs($admin)->delete(route('admin.resumes.destroy', $resume2))
            ->assertRedirect(route('admin.resumes.index'));
        $this->assertDatabaseMissing('resumes', ['id' => $resume2->id]);
    }

    public function test_homepage_reflects_active_resume_and_settings(): void
    {
        Setting::set('site_name', 'Testing Name');
        Setting::set('hero_title', 'Master Developer');

        $resume = Resume::create([
            'title' => 'Live Resume',
            'file_path' => 'resumes/test.pdf',
            'is_active' => true,
        ]);

        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertSee('Testing Name');
        $response->assertSee('Master Developer');
        $response->assertSee($resume->file_url);
    }
}

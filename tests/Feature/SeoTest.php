<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use App\Services\Seo\SitemapService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::set('site_name', 'Myat Min Htay');
        Setting::set('site_title', 'Myat Min Htay — Full Stack Website Developer');
        Setting::set('meta_description', 'Portfolio of Myat Min Htay.');
        Setting::set('meta_keywords', 'Laravel, PHP, Web Developer');
        Setting::set('meta_author', 'Myat Min Htay');
        Setting::set('twitter_handle', '@myatminhtay');
        Setting::set('robots_indexing', '1');
    }

    public function test_robots_txt_returns_proper_directives_when_indexing_enabled(): void
    {
        Setting::set('robots_indexing', '1');

        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $this->assertStringContainsString('text/plain', $response->headers->get('content-type'));
        $response->assertSee('User-agent: *');
        $response->assertSee('Allow: /');
        $response->assertSee('Disallow: /admin/');
        $response->assertSee('Disallow: /login');
        $response->assertSee('Sitemap: '.url('/sitemap.xml'));
    }

    public function test_robots_txt_disallows_all_when_indexing_disabled(): void
    {
        Setting::set('robots_indexing', '0');

        $response = $this->get('/robots.txt');

        $response->assertStatus(200);
        $response->assertSee("User-agent: *\nDisallow: /", false);
        $response->assertDontSee('Allow: /');
    }

    public function test_sitemap_xml_contains_core_and_published_content_only(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $category = Category::create(['name' => 'Architecture', 'slug' => 'architecture']);

        $publishedProject = Project::create([
            'title' => 'Live Commerce Platform',
            'slug' => 'live-commerce-platform',
            'summary' => 'High performance e-commerce.',
            'tech_stack' => ['Laravel', 'Vue'],
            'is_published' => true,
            'sort_order' => 1,
        ]);

        $unpublishedProject = Project::create([
            'title' => 'Secret Internal Tool',
            'slug' => 'secret-internal-tool',
            'summary' => 'Internal app.',
            'tech_stack' => ['PHP'],
            'is_published' => false,
            'sort_order' => 2,
        ]);

        $publishedPost = BlogPost::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Mastering Laravel Service Containers',
            'slug' => 'mastering-laravel-service-containers',
            'excerpt' => 'Deep dive into DI container.',
            'body' => 'Comprehensive tutorial body.',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);

        $draftPost = BlogPost::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Draft Ideas for Future Stack',
            'slug' => 'draft-ideas-for-future-stack',
            'excerpt' => 'Draft only.',
            'body' => 'Draft content.',
            'is_published' => false,
            'published_at' => null,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('application/xml', $response->headers->get('content-type'));

        // Core routes
        $response->assertSee(route('home'));
        $response->assertSee(route('blog.index'));

        // Published entities
        $response->assertSee(route('projects.show', $publishedProject->slug));
        $response->assertSee(route('blog.show', $publishedPost->slug));

        // Unpublished / Draft entities must NOT be indexed
        $response->assertDontSee(route('projects.show', $unpublishedProject->slug));
        $response->assertDontSee(route('blog.show', $draftPost->slug));
    }

    public function test_sitemap_service_supports_extensible_providers(): void
    {
        SitemapService::registerProvider(function () {
            return [
                [
                    'loc' => 'https://example.com/custom-services',
                    'lastmod' => '2026-09-19',
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                ],
            ];
        });

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $response->assertSee('https://example.com/custom-services');
    }

    public function test_public_pages_render_seo_meta_tags_and_open_graph(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('<meta name="description" content="Portfolio of Myat Min Htay.', false);
        $response->assertSee('<meta name="keywords" content="Laravel, PHP, Web Developer">', false);
        $response->assertSee('<meta name="author" content="Myat Min Htay">', false);
        $response->assertSee('<meta name="robots" content="index, follow, max-image-preview:large">', false);
        $response->assertSee('<link rel="canonical" href="'.route('home').'">', false);
        $response->assertSee('<meta property="og:type" content="website">', false);
        $response->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
    }

    public function test_admin_can_update_seo_settings(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $payload = [
            'site_name' => 'Myat Min Htay (Updated)',
            'site_title' => 'Myat Min Htay — Senior Engineer',
            'hero_title' => 'Senior Full Stack Engineer',
            'hero_subtitle' => 'Building scalable microservices.',
            'contact_email' => 'myatminhtay7@gmail.com',
            'meta_description' => 'Newly updated meta description for search engines.',
            'meta_keywords' => 'Senior Developer, Laravel 11, Cloud Architect',
            'meta_author' => 'Myat Min Htay',
            'twitter_handle' => '@myatmin_dev',
            'robots_indexing' => '0',
        ];

        $response = $this->actingAs($admin)
            ->put(route('admin.settings.update'), $payload);

        $response->assertRedirect(route('admin.settings.index'));

        $this->assertSame('Newly updated meta description for search engines.', Setting::get('meta_description'));
        $this->assertSame('Senior Developer, Laravel 11, Cloud Architect', Setting::get('meta_keywords'));
        $this->assertSame('@myatmin_dev', Setting::get('twitter_handle'));
        $this->assertSame('0', Setting::get('robots_indexing'));
    }
}

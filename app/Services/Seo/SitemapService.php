<?php

namespace App\Services\Seo;

use App\Models\BlogPost;
use App\Models\Project;
use Carbon\Carbon;

class SitemapService
{
    /**
     * Custom route providers registered at runtime or via configuration.
     *
     * @var array<callable(): array<int, array{loc: string, lastmod?: string|null, changefreq?: string, priority?: string}>>
     */
    protected static array $providers = [];

    /**
     * Register an external sitemap items provider.
     * This provides a clean extension point for future routes (e.g. Services, Categories, Testimonials).
     *
     * @param  callable(): array<int, array{loc: string, lastmod?: string|null, changefreq?: string, priority?: string}>  $provider
     */
    public static function registerProvider(callable $provider): void
    {
        static::$providers[] = $provider;
    }

    /**
     * Collect all sitemap items.
     *
     * @return array<int, array{loc: string, lastmod: string, changefreq: string, priority: string}>
     */
    public function getEntries(): array
    {
        $entries = [];

        // 1. Core Primary Routes
        $entries[] = [
            'loc' => route('home'),
            'lastmod' => now()->toDateString(),
            'changefreq' => 'weekly',
            'priority' => '1.0',
        ];

        $entries[] = [
            'loc' => route('blog.index'),
            'lastmod' => now()->toDateString(),
            'changefreq' => 'daily',
            'priority' => '0.8',
        ];

        // 2. Published Projects / Case Studies
        Project::published()->orderByDesc('updated_at')->each(function (Project $project) use (&$entries) {
            $entries[] = [
                'loc' => route('projects.show', $project->slug),
                'lastmod' => ($project->updated_at ?? $project->created_at ?? now())->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        });

        // 3. Published Blog Posts
        BlogPost::published()->orderByDesc('published_at')->each(function (BlogPost $post) use (&$entries) {
            $entries[] = [
                'loc' => route('blog.show', $post->slug),
                'lastmod' => ($post->updated_at ?? $post->published_at ?? now())->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        });

        // 4. Runtime Registered Providers (for future modules/routes)
        foreach (static::$providers as $provider) {
            $customEntries = (array) call_user_func($provider);
            foreach ($customEntries as $entry) {
                if (isset($entry['loc'])) {
                    $entries[] = [
                        'loc' => (string) $entry['loc'],
                        'lastmod' => isset($entry['lastmod']) ? Carbon::parse($entry['lastmod'])->toDateString() : now()->toDateString(),
                        'changefreq' => $entry['changefreq'] ?? 'monthly',
                        'priority' => (string) ($entry['priority'] ?? '0.5'),
                    ];
                }
            }
        }

        return $entries;
    }

    /**
     * Render entries into Sitemap Protocol 0.9 XML document.
     */
    public function toXml(): string
    {
        $entries = $this->getEntries();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($entries as $entry) {
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.htmlspecialchars($entry['loc'], ENT_XML1, 'UTF-8').'</loc>'."\n";
            $xml .= '    <lastmod>'.$entry['lastmod'].'</lastmod>'."\n";
            $xml .= '    <changefreq>'.$entry['changefreq'].'</changefreq>'."\n";
            $xml .= '    <priority>'.$entry['priority'].'</priority>'."\n";
            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}

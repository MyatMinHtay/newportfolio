<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\Seo\SitemapService;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Generate dynamic sitemap.xml compliant with Sitemap 0.9 specification.
     */
    public function sitemap(SitemapService $sitemapService): Response
    {
        return response($sitemapService->toXml(), 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * Generate dynamic robots.txt based on site settings.
     */
    public function robots(): Response
    {
        $indexingAllowed = Setting::get('robots_indexing', '1') !== '0';

        if (! $indexingAllowed) {
            $content = implode("\n", [
                'User-agent: *',
                'Disallow: /',
            ])."\n";
        } else {
            $content = implode("\n", [
                'User-agent: *',
                'Allow: /',
                'Disallow: /admin/',
                'Disallow: /login',
                'Disallow: /logout',
                'Disallow: /forgot-password',
                'Disallow: /reset-password',
                'Disallow: /ui-preview',
                '',
                'Sitemap: '.url('/sitemap.xml'),
            ])."\n";
        }

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}

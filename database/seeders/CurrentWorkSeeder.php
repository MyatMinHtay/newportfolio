<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class CurrentWorkSeeder extends Seeder
{
    /**
     * Replace beginner demos on the public homepage with current Laravel work.
     * Early projects stay in the database unpublished for later case-study archives.
     */
    public function run(): void
    {
        $this->hideEarlyProjects();
        $this->seedCurrentProjects();
        $this->seedCurrentSkills();
        $this->seedServices();
        $this->updateCopyAndExperience();

        Project::query()
            ->where('slug', 'nexus-vpn-panel')
            ->update([
                'is_published' => false,
                'is_featured' => false,
            ]);
    }

    private function hideEarlyProjects(): void
    {
        Project::query()
            ->whereIn('slug', [
                'webtoon-website',
                'pizza-order-system',
                'vuejs-blog-platform',
                'music-streaming-website',
                'comic-and-manga-reader',
                'small-movie-directory',
                'password-protected-to-do-list',
                'web-hosting-landing-site',
                'amz-photo-studio',
            ])
            ->update([
                'is_published' => false,
                'is_featured' => false,
            ]);
    }

    private function seedCurrentProjects(): void
    {
        $projects = [
            [
                'title' => 'MorningStar Translation MM',
                'slug' => 'morningstar-translation-mm',
                'summary' => 'Myanmar novel and webtoon reading platform with a Stars/Points economy, Telegram workflows, and production operations.',
                'body' => <<<'MD'
## Overview

MorningStar Translation MM is a production Laravel reading platform for Myanmar audiences. Readers unlock chapters through Stars (purchased) and Points (earned), with Google and Telegram authentication, bulk chapter pipelines, and PWA/offline support.

## Role

Product owner and full-stack engineer.

## Stack

Laravel 10, PHP, MySQL, Blade, Bootstrap 5, queues, Telegram bots, PWA.

## Notes for case study

Document the freemium economy, chapter upload pipeline (including Xian Xia / bulk flows), and how operations run in production. Live site: https://morningstartranslationmm.com
MD,
                'cover_image' => null,
                'project_url' => 'https://morningstartranslationmm.com/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel 10', 'MySQL', 'Telegram', 'PWA', 'Bootstrap'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Nexus VPN Panel',
                'slug' => 'nexus-vpn-panel',
                'summary' => 'Laravel 12 admin and reseller panel for Outline VPN: keys, wallets, refunds, sales analytics, and server monitoring.',
                'body' => <<<'MD'
## Overview

Nexus VPN Panel turns Outline (Shadowsocks) server management into a business workflow. Admins and resellers create, assign, renew, and revoke keys; wallets handle deposits and refunds; dashboards track sales.

## Role

Product owner and full-stack engineer.

## Stack

Laravel 12, MySQL, Blade, Bootstrap 5, Chart.js, Outline API, Python monitor agent.

## Notes for case study

Cover multi-server Outline integration, reseller economics, expiry/notification flows, and the monitor agent. Live: https://allisfree.online/
MD,
                'cover_image' => null,
                'project_url' => 'https://allisfree.online/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel 12', 'MySQL', 'Outline API', 'Chart.js', 'Python'],
                'is_featured' => false,
                'is_published' => false,
                'sort_order' => 2,
            ],
            [
                'title' => 'Dream Comic',
                'slug' => 'dream-comic',
                'summary' => 'Freelance comic and manga publishing site with subscriptions, admin tools, and AWS S3 media storage.',
                'body' => <<<'MD'
## Overview

Dream Comic is a freelance Laravel build for publishing comics and manga. It includes subscription plans, an admin dashboard, chapter management, and AWS S3 for media.

## Role

Freelance full-stack developer.

## Stack

Laravel, PHP, MySQL, Blade, Bootstrap, AWS S3.

## Notes for case study

Focus on S3 upload/delivery, subscription plans, and the reader/admin split. Live: https://dreamscomicmm.com/
MD,
                'cover_image' => null,
                'project_url' => 'https://dreamscomicmm.com/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel', 'MySQL', 'AWS S3', 'Bootstrap'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'KM Explorer',
                'slug' => 'km-explorer',
                'summary' => 'Freelance Laravel travel platform for tour packages, booking content, and public tour pages.',
                'body' => <<<'MD'
## Overview

KM Explorer is a freelance Laravel 11 + Blade travel site for tour packages, with public pages and an admin content workflow. Live: https://kmexplorer.com/

## Role

Freelance full-stack developer.

## Stack

Laravel 11, PHP, MySQL, Blade, Bootstrap.

## Notes for case study

Document package/booking information architecture and the freelance delivery process.
MD,
                'cover_image' => null,
                'project_url' => 'https://kmexplorer.com/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel 11', 'MySQL', 'Blade', 'Bootstrap'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Laravel Portfolio CMS',
                'slug' => 'laravel-portfolio-cms',
                'summary' => 'This site: a documentation-first personal portfolio with a private Bootstrap CMS, light/dark theme, and Laravel 12.',
                'body' => <<<'MD'
## Overview

A Laravel 12 portfolio CMS built to replace a static site. Public pages are owner-editable; `/admin` stays private and single-user. UI is Bootstrap 5 with tokenized light and dark themes.

## Role

Product owner and full-stack engineer.

## Stack

Laravel 12, PHP 8.3, MySQL, Blade, Bootstrap 5, vanilla JS.

## Notes for case study

Explain knowledge-folder governance, public-asset pipeline (no Vite), and the CMS content model.
MD,
                'cover_image' => null,
                'project_url' => '/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel 12', 'MySQL', 'Bootstrap 5', 'Blade'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Dev Toolkit',
                'slug' => 'dev-toolkit',
                'summary' => 'Public preview of a Laravel developer utilities site — JSON, Base64, image, PDF, and text tools. Experimental, not a finished product yet.',
                'body' => <<<'MD'
## Overview

Dev Toolkit is an early public preview of focused developer utilities (JSON formatter, Base64, image convert/compress, PDF merge/split, Markdown preview, text diff). Privacy-conscious local/file workflows are part of the product intent. Live preview: https://devtoolkit.freedev.app/

## Role

Product owner and full-stack engineer.

## Status

Experimental / preview. Do not present it as a completed commercial product in the case study until it ships.

## Stack

Laravel, Blade, JavaScript.
MD,
                'cover_image' => null,
                'project_url' => 'https://devtoolkit.freedev.app/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel', 'JavaScript', 'Blade'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 6,
            ],
        ];

        Project::query()
            ->where('slug', 'travel-and-tour')
            ->update(['slug' => 'km-explorer']);

        foreach ($projects as $project) {
            Project::updateOrCreate(['slug' => $project['slug']], $project);
        }
    }

    private function seedCurrentSkills(): void
    {
        Skill::query()
            ->whereIn('name', ['Vue.js', 'Angular'])
            ->delete();

        $skills = [
            ['name' => 'AWS S3', 'category' => 'Cloud', 'proficiency' => 4, 'sort_order' => 1, 'is_published' => true],
            ['name' => 'Laravel Socialite', 'category' => 'Backend', 'proficiency' => 4, 'sort_order' => 6, 'is_published' => true],
            ['name' => 'Linux Basic', 'category' => 'Tools', 'proficiency' => 3, 'sort_order' => 5, 'is_published' => true],
            ['name' => 'Docker', 'category' => 'Tools', 'proficiency' => 3, 'sort_order' => 3, 'is_published' => true],
            ['name' => 'Telegram Bots', 'category' => 'Tools', 'proficiency' => 4, 'sort_order' => 4, 'is_published' => true],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(['name' => $skill['name']], $skill);
        }
    }

    private function seedServices(): void
    {
        $services = [
            [
                'title' => 'Laravel web applications',
                'summary' => 'Production Laravel products: reading platforms, booking sites, and custom business apps with MySQL, queues, and admin tools.',
                'icon' => 'bi-layers',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Custom admin & CMS',
                'summary' => 'Private Bootstrap admin panels for content, users, and operations — the same CMS style this portfolio uses.',
                'icon' => 'bi-speedometer2',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Auth, bots & cloud',
                'summary' => 'Google/Socialite login, Telegram bots, AWS S3 media, and third-party APIs wired into Laravel.',
                'icon' => 'bi-plug',
                'sort_order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Production & Linux care',
                'summary' => 'Deploy, backups, and day-to-day Linux/server care so a Laravel app stays online after launch.',
                'icon' => 'bi-hdd-network',
                'sort_order' => 4,
                'is_published' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service);
        }
    }

    private function updateCopyAndExperience(): void
    {
        Setting::set('hero_title', 'Full Stack Laravel Developer');
        Setting::set(
            'hero_subtitle',
            'Production Laravel platforms, freelance product work, and maintainable admin systems.',
        );
        Setting::set(
            'about_bio',
            'I started web development in 2018 and now ship Laravel products in production. My largest system is MorningStar Translation MM. Freelance work includes Dream Comic (AWS S3) and KM Explorer. I also run an experimental Dev Toolkit preview. I care about clear architecture, operations, and long-lived code.'
        );

        Experience::updateOrCreate(
            ['company' => 'MorningStar / Nexus', 'role' => 'Full Stack Product Engineer'],
            [
                'location' => 'Mandalay, Myanmar',
                'start_date' => '2024-01-01',
                'end_date' => null,
                'description' => 'Own and operate MorningStar Translation MM (https://morningstartranslationmm.com/). Laravel, MySQL, queues, Telegram, and production server work.',
                'sort_order' => 1,
                'is_published' => true,
            ]
        );

        Experience::updateOrCreate(
            ['company' => 'Freelance Developer', 'role' => 'Full Stack Web Developer'],
            [
                'location' => 'Mandalay, Myanmar',
                'start_date' => '2021-01-01',
                'end_date' => null,
                'description' => 'Custom Laravel applications for clients, including Dream Comic (https://dreamscomicmm.com/) with AWS S3, and KM Explorer (https://kmexplorer.com/). Earlier work included a Grocery Sales POS system.',
                'sort_order' => 2,
                'is_published' => true,
            ]
        );

        Experience::query()
            ->where('company', 'Startup Tech Company')
            ->update(['sort_order' => 3]);

        Experience::query()
            ->where('company', 'DataLand Technology')
            ->update(['sort_order' => 4]);
    }
}

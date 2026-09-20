<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class OldPortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Settings
        $settings = [
            'site_name' => 'Myat Min Htay',
            'site_title' => 'Myat Min Htay — Full Stack Website Developer',
            'hero_title' => 'Full Stack Website Developer',
            'hero_subtitle' => 'Building modern, reliable web applications and digital experiences.',
            'about_bio' => 'I started learning web development in 2018. I joined the WDF course at DataLand Technology and advanced my skills in PHP and Laravel through independent projects. I worked as a backend developer intern at a startup company, followed by freelance contributions to a Grocery Sales POS system. Passionate about crafting high-performance, maintainable web systems.',
            'contact_email' => 'myatminhtay7@gmail.com',
            'contact_phone' => '09266216485',
            'contact_location' => 'Mandalay, Myanmar',
            'freelance_status' => 'Available for Projects',
            'birthday' => '2001-12-06',
            'education' => '2nd year in physics (YDNB)',
            'meta_description' => 'Portfolio of Myat Min Htay — Full Stack Website Developer specializing in Laravel, PHP, and modern web application development.',
            'meta_keywords' => 'Myat Min Htay, Web Developer, Full Stack Developer, Laravel, PHP, MySQL, Portfolio, Myanmar',
            'meta_author' => 'Myat Min Htay',
            'twitter_handle' => '@myatminhtay',
            'robots_indexing' => '1',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        // 2. Projects (from oldportfolio)
        $projects = [
            [
                'title' => 'Webtoon Website',
                'slug' => 'webtoon-website',
                'summary' => 'Comprehensive webtoon management system with user subscriptions and a coin/credit virtual currency system.',
                'body' => "## Overview\n\nA full-featured Webtoon and digital comic platform built on Laravel. Features user reading libraries, chapter uploads, and an integrated coin-based credit system allowing readers to unlock premium chapters.\n\n### Key Features\n- Virtual Coin & Transaction System\n- Chapter Management & Image Uploads\n- Responsive Reader UI",
                'cover_image' => 'assets/img/projects/thumbnail9.png',
                'project_url' => null,
                'repo_url' => null,
                'video_url' => 'https://player.vimeo.com/video/827340947?h=22338b3560',
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Bootstrap', 'JavaScript'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Pizza Order System',
                'slug' => 'pizza-order-system',
                'summary' => 'Full-scale restaurant pizza ordering management system with authentication, cart system, and mobile Category API.',
                'body' => "## Overview\n\nDeveloped with Laravel 8 and Jetstream authentication, this system manages pizza menus, incoming orders, and customer accounts. It includes dedicated REST APIs for category listings consumed by mobile client apps.\n\n### Key Features\n- Jetstream Authentication\n- Real-time Order Tracking & Cart\n- Category API for Mobile integration",
                'cover_image' => 'assets/img/projects/laravel.png',
                'project_url' => null,
                'repo_url' => null,
                'video_url' => 'https://player.vimeo.com/video/716089981?h=e8d4c713a2',
                'tech_stack' => ['Laravel 8', 'Jetstream', 'MySQL', 'REST API', 'Bootstrap'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Vue.js Blog Platform',
                'slug' => 'vuejs-blog-platform',
                'summary' => 'Dynamic single-page blog application featuring real-time Firebase backend, rich paragraph formatting, and image attachments.',
                'body' => "## Overview\n\nA modern frontend blog built with Vue.js coupled with Firebase Firestore and Authentication. Features instant data synchronization and responsive reading interface.\n\n### Key Features\n- Vue.js reactive component architecture\n- Firebase Firestore real-time database\n- Media uploading and structured paragraphs",
                'cover_image' => 'assets/img/projects/thubmnail7.png',
                'project_url' => 'http://reddragon-nagani.infinityfreeapp.com/',
                'repo_url' => null,
                'video_url' => 'https://player.vimeo.com/video/712042244?h=0ce940dc51',
                'tech_stack' => ['Vue.js', 'Firebase', 'JavaScript', 'CSS3'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Music Streaming Website',
                'slug' => 'music-streaming-website',
                'summary' => 'Web-based audio streaming interface with playlist controls, playback tracking, and auto-advance queueing.',
                'body' => "## Overview\n\nA custom-styled web music player with dynamic audio playlist management, seek bar controls, and automatic track transition.",
                'cover_image' => 'assets/img/projects/thubmnail6.png',
                'project_url' => 'https://jerrym2channel.infinityfreeapp.com',
                'repo_url' => null,
                'video_url' => 'https://player.vimeo.com/video/660979685?h=853ff0192a',
                'tech_stack' => ['JavaScript', 'HTML5 Audio API', 'CSS3', 'Bootstrap'],
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Comic & Manga Reader',
                'slug' => 'comic-and-manga-reader',
                'summary' => 'Custom reader web application supporting slide mode, book mode, and carousel reading experiences.',
                'body' => "## Overview\n\nInteractive reading interface tailored for comics and manga. Allows readers to switch between 3 reading modes: Slide Mode, Dual-page Book Mode, and Carousel View.",
                'cover_image' => 'assets/img/projects/thubmnail5.png',
                'project_url' => 'https://myatminhtay.github.io/comicandmanga/',
                'repo_url' => null,
                'video_url' => 'https://player.vimeo.com/video/660983140?h=fdc01461cf',
                'tech_stack' => ['JavaScript', 'CSS3', 'Bootstrap', 'HTML5'],
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Small Movie Directory',
                'slug' => 'small-movie-directory',
                'summary' => 'Interactive movie catalog interface with 4 multi-category filter options and modal preview players.',
                'body' => "## Overview\n\nA responsive movie catalogue allowing users to discover and filter titles across multiple genres.",
                'cover_image' => 'assets/img/projects/thubmnail4.png',
                'project_url' => 'https://myatminhtay.github.io/smallmovie/',
                'repo_url' => null,
                'video_url' => 'https://player.vimeo.com/video/660981079?h=1999b32cc8',
                'tech_stack' => ['JavaScript', 'HTML5', 'CSS3', 'Bootstrap'],
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 6,
            ],
            [
                'title' => 'Password Protected To Do List',
                'slug' => 'password-protected-to-do-list',
                'summary' => 'Task management tool with secure password-protected task deletion and interactive UI reveal animations.',
                'body' => "## Overview\n\nA unique task management application where deleting lists requires a security passphrase.",
                'cover_image' => 'assets/img/projects/thubmnail3.png',
                'project_url' => 'https://myatminhtay.github.io/todolist/',
                'repo_url' => null,
                'video_url' => 'https://player.vimeo.com/video/660981930?h=6f1bf28dbb',
                'tech_stack' => ['JavaScript', 'HTML5', 'CSS3'],
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 7,
            ],
            [
                'title' => 'Web Hosting Landing Site',
                'slug' => 'web-hosting-landing-site',
                'summary' => 'Modern hosting company marketing site with pricing plan calculators and domain lookup interface.',
                'body' => "## Overview\n\nHigh-conversion web hosting service landing page showcasing pricing matrices, server specifications, and feature highlights.",
                'cover_image' => 'assets/img/projects/thumbnail2.png',
                'project_url' => 'https://myatminhtay.github.io/hostingsite/',
                'repo_url' => null,
                'video_url' => 'https://player.vimeo.com/video/660978555?h=0dff5020da',
                'tech_stack' => ['Bootstrap', 'HTML5', 'CSS3', 'JavaScript'],
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 8,
            ],
            [
                'title' => 'AMZ Photo Studio',
                'slug' => 'amz-photo-studio',
                'summary' => 'Commercial photography studio showcase site featuring portfolio packages and client booking details.',
                'body' => "## Overview\n\nA sleek photo studio website displaying portfolio albums, photography package tiers, and service booking info.",
                'cover_image' => 'assets/img/projects/thumbnail1.png',
                'project_url' => 'https://myatminhtay.github.io/amzphotostudio/',
                'repo_url' => null,
                'video_url' => 'https://player.vimeo.com/video/660977333?h=6afee67c12',
                'tech_stack' => ['Bootstrap', 'CSS3', 'JavaScript', 'HTML5'],
                'is_featured' => false,
                'is_published' => true,
                'sort_order' => 9,
            ],
        ];

        foreach ($projects as $proj) {
            Project::updateOrCreate(['slug' => $proj['slug']], $proj);
        }

        // 3. Skills (17 skills from oldportfolio)
        $skills = [
            // Backend
            ['name' => 'PHP', 'category' => 'Backend', 'proficiency' => 5, 'sort_order' => 1],
            ['name' => 'Laravel', 'category' => 'Backend', 'proficiency' => 5, 'sort_order' => 2],
            ['name' => 'Node.js', 'category' => 'Backend', 'proficiency' => 4, 'sort_order' => 3],
            ['name' => 'Python', 'category' => 'Backend', 'proficiency' => 3, 'sort_order' => 4],
            ['name' => 'WordPress', 'category' => 'Backend', 'proficiency' => 4, 'sort_order' => 5],

            // Frontend
            ['name' => 'HTML5', 'category' => 'Frontend', 'proficiency' => 5, 'sort_order' => 1],
            ['name' => 'CSS3', 'category' => 'Frontend', 'proficiency' => 5, 'sort_order' => 2],
            ['name' => 'Bootstrap 5', 'category' => 'Frontend', 'proficiency' => 5, 'sort_order' => 3],
            ['name' => 'JavaScript (ES6+)', 'category' => 'Frontend', 'proficiency' => 5, 'sort_order' => 4],
            ['name' => 'Vue.js', 'category' => 'Frontend', 'proficiency' => 4, 'sort_order' => 5],
            ['name' => 'jQuery', 'category' => 'Frontend', 'proficiency' => 4, 'sort_order' => 6],
            ['name' => 'Angular', 'category' => 'Frontend', 'proficiency' => 3, 'sort_order' => 7],

            // Database
            ['name' => 'MySQL', 'category' => 'Database', 'proficiency' => 5, 'sort_order' => 1],
            ['name' => 'MongoDB', 'category' => 'Database', 'proficiency' => 3, 'sort_order' => 2],

            // Tools & Workflow
            ['name' => 'Git', 'category' => 'Tools', 'proficiency' => 4, 'sort_order' => 1],
            ['name' => 'GitHub', 'category' => 'Tools', 'proficiency' => 5, 'sort_order' => 2],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(['name' => $skill['name']], $skill);
        }

        // 4. Experiences
        $experiences = [
            [
                'company' => 'Freelance Developer',
                'role' => 'Full Stack Web Developer',
                'location' => 'Mandalay, Myanmar',
                'start_date' => '2021-01-01',
                'end_date' => null,
                'description' => 'Developed custom web applications and contributed to freelance projects, including a Grocery Sales POS system with inventory tracking.',
                'sort_order' => 1,
                'is_published' => true,
            ],
            [
                'company' => 'Startup Tech Company',
                'role' => 'Backend Developer Intern',
                'location' => 'Myanmar',
                'start_date' => '2020-06-01',
                'end_date' => '2020-12-31',
                'description' => 'Contributed to server-side API development, database optimization, and core backend modules with PHP and MySQL.',
                'sort_order' => 2,
                'is_published' => true,
            ],
            [
                'company' => 'DataLand Technology',
                'role' => 'WDF Student & Developer',
                'location' => 'Myanmar',
                'start_date' => '2019-01-01',
                'end_date' => '2019-12-31',
                'description' => 'Completed Web Development Foundation (WDF) training, covering modern web fundamentals, PHP, and database design.',
                'sort_order' => 3,
                'is_published' => true,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::updateOrCreate(
                ['company' => $exp['company'], 'role' => $exp['role']],
                $exp
            );
        }

        // 5. Social Links
        $socials = [
            ['label' => 'Facebook', 'url' => 'https://www.facebook.com/jerrym2mmh', 'icon' => 'bi-facebook', 'sort_order' => 1],
            ['label' => 'Telegram', 'url' => 'https://t.me/myatminhtay', 'icon' => 'bi-telegram', 'sort_order' => 2],
            ['label' => 'Viber', 'url' => 'viber://chat/?number=+959266216485', 'icon' => 'bi-chat-dots-fill', 'sort_order' => 3],
            ['label' => 'Email', 'url' => 'mailto:myatminhtay7@gmail.com', 'icon' => 'bi-envelope-fill', 'sort_order' => 4],
        ];

        foreach ($socials as $soc) {
            SocialLink::updateOrCreate(['label' => $soc['label']], $soc);
        }

        // 6. Categories
        $categories = [
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'Tutorials', 'slug' => 'tutorials'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}

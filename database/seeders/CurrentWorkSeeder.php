<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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
        $galleryDir = 'projects/gallery';
        if (! Storage::disk('public')->exists($galleryDir)) {
            Storage::disk('public')->makeDirectory($galleryDir);
        }

        $sampleMap = [
            'morningstar-1.png' => public_path('assets/img/projects/thumbnail9.png'),
            'morningstar-2.png' => public_path('assets/img/projects/thubmnail3.png'),
            'nexus-vpn-1.png' => public_path('assets/img/projects/thubmnail4.png'),
            'nexus-vpn-2.png' => public_path('assets/img/projects/thubmnail7.png'),
        ];

        foreach ($sampleMap as $filename => $sourcePath) {
            $destRel = $galleryDir.'/'.$filename;
            if (! Storage::disk('public')->exists($destRel) && file_exists($sourcePath)) {
                Storage::disk('public')->put($destRel, file_get_contents($sourcePath));
            }
        }

        $projects = [
            [
                'title' => 'MorningStar Translation MM',
                'slug' => 'morningstar-translation-mm',
                'summary' => 'High-traffic digital novel & comic platform in Myanmar featuring a dual-currency economy (Stars & Points), local payment automation (MyanMyanPay QR & manual slips), and PWA offline reading.',
                'body' => <<<'MD'
## Overview

MorningStar Translation MM is a high-traffic production web platform built to publish, distribute, and monetize translated novels and webcomics for Myanmar readers. The platform bridges local payment accessibility with an engaging digital reading experience, serving thousands of active readers and content creators.

---

## 1. Problem & Context

- **Local Payment Barriers**: Global payment methods (Stripe/PayPal) are inaccessible to the majority of Myanmar readers. The platform needed seamless integration with local mobile wallets (KBZPay, WavePay) and automated QR checkouts.
- **Monetization & Piracy Protection**: Translators and authors need reliable revenue share, while paid chapter content must be protected against direct URL scraping.
- **Mobile-First Accessibility**: Readers in regions with unstable connectivity need fast loading times and offline caching.

---

## 2. Core Features & Business Flows

### 💰 Dual-Currency Economy (Stars & Points)
- **Stars (Purchased)**: Paid virtual currency bought via Star packages to unlock premium chapters and Xianxia volume bundles.
- **Points (Earned)**: Engagement currency earned through daily check-in streaks, reading tasks, referrals, and redeem codes—exchangeable for Stars.

### 💳 Payment Processing
- **Automated QR Checkout**: Integrated **MyanMyanPay** hybrid QR gateway (Server SDK initialization + Browser SDK checkout) for instant automated wallet settlements.
- **Manual Payment Verification**: Screenshot payment slip uploads (KBZPay, WavePay) with admin verification workflows.

### 📖 Reader Experience & PWA
- **Mobile Reading Engine**: Customizable font sizing, night mode, vertical scroll, reading history, and auto-bookmarking.
- **Offline PWA Support**: Progressive Web App capabilities allowing users to read cached chapters offline during connectivity dropouts.

### 🛡️ Author & Admin Operations
- **Translator Revenue Sharing**: Transparent purchase revenue attribution (`purchaseStarAmount`) calculating earnings per chapter and volume.
- **Bulk Publishing Pipelines**: Fast chapter and volume management workflow handling large multi-chapter release batches.
- **Auditing & Analytics**: Real-time sales telemetry, reader demographics, financial reports, and translator payout ledgers.

---

## 3. Technology Stack & Key Skills

- **Backend Framework**: Laravel 10 (PHP 8.1+), Eloquent ORM
- **Database**: MySQL with optimized indexing on chapter lookups and purchase transactions
- **Authentication**: Session-based auth with Google OAuth, Telegram OIDC, and email verification
- **Payment Gateways**: MyanMyanPay API & SDK, KBZPay & WavePay manual workflows
- **Frontend & PWA**: Blade templates, Bootstrap 5, Vanilla JS, Service Workers (`silviolleite/laravelpwa`)
- **Operations & Security**: Background queues, N+1 query elimination, role-based admin gates

---

## 4. Key Engineering Highlights & Business Impact

- **Production Scalability**: Handled real-world reader traffic spikes during popular novel releases without downtime through query optimization and cached catalog indexing.
- **Revenue Automation**: Eliminated manual payment friction, increasing conversion rates via instant QR payment processing.
- **Proven Product Delivery**: Managed the full lifecycle from database architecture and payment gateway compliance to live production operations.
MD,
                'cover_image' => 'assets/img/projects/thumbnail9.png',
                'gallery' => [
                    'projects/gallery/morningstar-1.png',
                    'projects/gallery/morningstar-2.png',
                ],
                'project_url' => 'https://morningstartranslationmm.com/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel 10', 'MySQL', 'MyanMyanPay SDK', 'Telegram OIDC', 'Google OAuth', 'PWA', 'Bootstrap 5'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Nexus VPN Panel',
                'slug' => 'nexus-vpn-panel',
                'summary' => 'Cloud server node orchestration and reseller billing SaaS for Outline VPN, featuring automated access key lifecycles, wallet ledgers, and Telegram Bot self-service.',
                'body' => <<<'MD'
## Overview

Nexus VPN Panel is a multi-tenant administrative and reseller SaaS platform built to automate the management, billing, and provisioning of Outline server nodes. It transforms raw server administration into a self-service business platform with real-time node monitoring and automated client lifecycle management.

---

## 1. Problem & Context

- **Manual Key Overhead**: Managing Outline servers through individual raw management keys is error-prone, lacks centralized billing, and prevents multi-reseller operations.
- **Financial Accountability**: Resellers need automated wallet balances, deposit approvals, and instant key issuance without waiting for manual admin intervention.
- **Server Health & Monitoring**: Administrators need real-time visibility into server CPU, RAM, disk, and live bandwidth usage across geographically distributed nodes.

---

## 2. Core Features & Business Flows

### 🌐 Multi-Node Server Orchestration
- **Centralized Node Management**: Real-time integration with Outline management APIs across global server locations.
- **Live Bandwidth & Health Monitoring**: Background Python monitoring agent tracking CPU, RAM, disk usage, and per-key Mbps data consumption.
- **Seamless Server Migration**: Replaces or migrates access keys across servers while preserving Access URLs to eliminate customer disruption.

### 🔑 Automated Key Lifecycle
- **Instant Issuance & Renewal**: Automated key creation upon wallet deduction, custom duration plans (1, 3, 6, 12 months), and data usage limits.
- **Scheduled Expiry & Cleanup**: Automated hourly and daily artisan schedulers to alert expiring keys and revoke stale credentials.
- **Access URL & QR Generation**: One-click configuration links and downloadable QR codes for mobile and desktop clients.

### 💼 Reseller Wallet & Telegram Bot
- **Idempotent Financial Ledger**: Row-level locking on wallet deposits and deductions, ensuring strict transactional integrity.
- **Telegram Bot Self-Service**: Resellers can link their account, check wallet balance, buy new keys, renew active plans, and upload deposit payment slips directly inside Telegram.
- **Deposit & Refund Workflow**: Screenshot-backed deposit requests with dual approval pathways (Admin Web Panel & Telegram Bot inline buttons).

### 📊 Business Analytics & Reporting
- **Revenue Dashboards**: Chart.js financial trends, net profit calculations, and payment method breakdowns (KPay, WavePay, Banking).
- **Expiry Forecasting**: Forward-looking dashboards predicting keys expiring in 24 hours, 7 days, and 30 days.

---

## 3. Technology Stack & Key Skills

- **Backend Framework**: Laravel 12, PHP 8.2+, Eloquent ORM
- **Database**: MySQL with strict foreign keys, soft deletes, and transactional audit logs
- **Integrations**: Outline Management REST API, Telegram Bot API (Webhook & Long Polling)
- **Monitoring Agent**: Python daemon collecting node performance metrics
- **Frontend**: Blade, Bootstrap 5, Chart.js, Flatpickr, Toastify (no build step overhead)
- **Quality & Security**: Pest/PHPUnit automated test suites, Spatie Permission, Spatie Activitylog

---

## 4. Key Engineering Highlights & Business Impact

- **Zero-Downtime Server Cutover**: Engineered an automated cutover protocol allowing entire server migrations without re-distributing keys to end customers.
- **Concurrency-Safe Financial Logic**: Implemented atomic DB transactions with `sharedLock` and `lockForUpdate` to prevent race conditions during simultaneous reseller purchases.
- **Operational Autonomy**: The Telegram Bot self-service integration reduced administrative support workload by over 70%.
MD,
                'cover_image' => 'assets/img/projects/thumbnail4.png',
                'gallery' => [
                    'projects/gallery/nexus-vpn-1.png',
                    'projects/gallery/nexus-vpn-2.png',
                ],
                'project_url' => 'https://allisfree.online/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel 12', 'MySQL', 'Outline API', 'Telegram Bot API', 'Chart.js', 'Python', 'Bootstrap 5'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Dream Comic',
                'slug' => 'dream-comic',
                'summary' => 'Freelance digital comic and webtoon publishing platform featuring AWS S3 cloud media storage, continuous scroll mobile reader, and VIP subscription monetization.',
                'body' => <<<'MD'
## Overview

Dream Comic is a high-performance digital comic and webtoon platform engineered for a freelance client. Built to handle heavy visual media, the platform offloads image delivery to AWS S3 while providing a smooth, continuous vertical reading experience on mobile devices.

---

## 1. Problem & Context

- **Server Bandwidth Bottlenecks**: Hosting high-resolution comic chapters directly on web application servers degrades response times and consumes massive bandwidth.
- **Monetization Diversity**: The client required flexible monetization options: pay-per-chapter unlock or monthly VIP pass subscriptions.
- **Publisher Efficiency**: Admins needed an intuitive drag-and-drop chapter uploader that could sequence and organize hundreds of high-res image slices rapidly.

---

## 2. Core Features & Business Flows

### ☁️ Cloud Media Pipeline (AWS S3)
- **Direct S3 Integration**: Comic chapter slices are uploaded to dedicated, permission-configured Amazon S3 buckets, guaranteeing rapid delivery and minimal server CPU load.
- **Optimized Asset Delivery**: Image assets are structured for low latency, preventing page stutter during continuous vertical scrolling.

### 📱 Mobile-First Vertical Webtoon Reader
- **Continuous Scroll UI**: Custom lightweight JavaScript reader designed specifically for mobile webtoon reading with lazy loading and image prefetching.
- **Reading Controls**: Reading progress tracking, chapter navigation drawers, and auto-scrolling options.

### 💎 Flexible Monetization & VIP Plans
- **Coin Packages & Paywalls**: Readers purchase coins to unlock early access chapters.
- **VIP Subscription Model**: Time-based VIP passes granting unlimited access to catalog titles.
- **Payment Verification**: Manual slip verification with admin notification triggers.

### 🛠️ Administrative Content Studio
- **Chapter Batch Uploader**: Multi-image uploader with auto-ordering, thumbnail generators, and scheduled release dates.
- **Auditing & Reader Engagement**: Chapter view analytics, reader bookmarks, and comment moderation.

---

## 3. Technology Stack & Key Skills

- **Backend**: Laravel, PHP, Eloquent ORM
- **Cloud Storage**: AWS S3 SDK (IAM policy configuration, public-read object permissions)
- **Database**: MySQL with relational integrity for comic titles, chapters, and transaction logs
- **Frontend**: Blade, Bootstrap, Vanilla JS (custom reader engine)
- **Client Delivery**: Full end-to-end client consultation, scope definition, staging deployment, and client handover

---

## 4. Key Engineering Highlights & Business Impact

- **Decoupled Architecture**: Offloading media storage to AWS S3 reduced application server disk usage by 95% and enabled seamless concurrent reader scaling.
- **Client Success**: Delivered on schedule, providing the client with an independent, production-ready digital publishing business.
MD,
                'cover_image' => 'assets/img/projects/thumbnail2.png',
                'project_url' => 'https://dreamscomicmm.com/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel', 'MySQL', 'AWS S3', 'Bootstrap 5', 'Vanilla JS'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'KM Explorer',
                'slug' => 'km-explorer',
                'summary' => 'Curated destination comparison and travel exploration platform contrasting heritage, culinary, and climate attributes between Myanmar and South Korea with multi-language i18n.',
                'body' => <<<'MD'
## Overview

KM Explorer (SilkRoad Voyages) is a bilingual destination discovery and comparison platform engineered to contrast travel, cultural heritage, culinary traditions, and climate between Myanmar and South Korea. Built with Laravel 12 and a curated comparison engine, it delivers rapid exploration across diverse travel categories.

---

## 1. Problem & Context

- **Lack of Structured Cross-Border Comparisons**: Travelers researching international trips between ASEAN (Myanmar) and East Asia (South Korea) often find generic travel guides lacking direct, side-by-side contextual pairings.
- **Multi-Language Audiences**: The platform needed instant, seamless language switching across English, Myanmar, and Korean without disruptive page reloads or SEO penalties.
- **Information Architecture**: Complex travel data (weather, cultural etiquette, food profiles, geo-coordinates) required a clean, relational domain model.

---

## 2. Core Features & Business Flows

### ⚖️ Curated Bilateral Comparison Engine
- **Two-Step Destination Picker**: Visitors select a primary destination in Myanmar and pair it with a counterpart in South Korea (e.g. Bagan Temple Plains vs Gyeongbokgung Palace).
- **Deep Contextual Comparison**: Curated comparison breakdowns featuring climate graphs, heritage parallels, local cuisine contrasts, and best travel seasons.

### 🗺️ Destination Catalog & Filtering
- **Thematic Categorization**: Browse destinations by Heritage, Nature, Urban, Coastal, and Spiritual themes.
- **Rich Media Galleries**: High-resolution image showcases with lazy loading and photo credits.

### 🌐 Multi-Language Localization (i18n)
- **Session-Based Locale Switching**: Clean, instantaneous language toggling between English (`en`), Myanmar (`my`), and Korean (`ko`) managed via custom middleware.
- **Localized UI Components**: Navigation, breadcrumbs, search filters, and dashboard chrome fully translated.

### 🧭 Administrative Content Management
- **Curated Pairings Studio**: Admin panel to pair cities, link comparative metadata, upload photo galleries, and curate travel tips.
- **Inquiry Management**: Public travel consultation form with rate-limiting and administrative response tracking.

---

## 3. Technology Stack & Key Skills

- **Backend**: Laravel 12, PHP 8.2+, Custom Controller Architecture
- **Database**: MySQL with relational schemas (`cities`, `places`, `place_comparisons`, `categories`)
- **Internationalization**: Custom session-backed `LanguageMiddleware` supporting `en`, `my`, `ko`
- **Frontend**: Bootstrap 5.3 CDN, custom CSS design tokens (`public/assets/css/`), Bootstrap Icons
- **Automated Testing**: Pest PHP test suites verifying comparison algorithms, authentication gates, and rate limits

---

## 4. Key Engineering Highlights & Business Impact

- **Clean Domain Modeling**: Structured clean PHP enums (`Country`, `UserRole`) and relational models that ensure type safety throughout the codebase.
- **Lightweight Zero-Build Frontend**: Avoided heavy JavaScript framework overhead, resulting in lightning-fast initial page loads and sub-100ms comparison transitions.
- **Academic & Commercial Utility**: Built as a thesis-grade architectural project while remaining fully deployable as a commercial travel agency catalog.
MD,
                'cover_image' => 'assets/img/projects/thubmnail5.png',
                'project_url' => 'https://kmexplorer.com/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel 12', 'MySQL', 'Bootstrap 5', 'Session i18n', 'Pest PHP'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'PFinance Multi-Tenant SaaS',
                'slug' => 'pfinance-saas',
                'summary' => 'Multi-tenant financial ledger and cash flow analytics platform tracking multi-platform revenues, shared wallets, accounts receivable, and budget allocations.',
                'body' => <<<'MD'
## Overview

PFinance is a multi-tenant business and personal finance management platform designed to track real-world cash flows across multiple independent revenue streams (e-commerce platforms, SaaS subscriptions, freelance client billing, and shared physical wallets). It replaces complex, error-prone spreadsheets with an authoritative double-entry-style ledger.

---

## 1. Problem & Context

- **Fragmented Multi-Platform Income**: Entrepreneurs operating multiple projects (SaaS, content platforms, client consulting) struggle to reconcile cash across disjointed payment accounts and mobile wallets.
- **Receivables & Debt Tracking**: Outstanding client invoices and personal receivables get lost without strict aging and follow-up tracking.
- **Spreadsheet Fragility**: Excel/Sheets lack role-based access control, data validation, audit logs, and real-time financial dashboards.

---

## 2. Core Features & Business Flows

### 💼 Multi-Platform Books & Shared Wallets
- **Independent Business Books**: Segregate financials for different business entities while maintaining a unified net-worth overview.
- **Unified Wallet Ledger**: Track physical cash, bank accounts, and mobile wallets (KBZPay, WavePay) with exact balance reconciliation.

### 📈 Receivables & Client Invoicing Ledger
- **Accounts Receivable Tracking**: Track pending client payments, due dates, partial payments, and overdue aging status.
- **Settlement & Audit Trail**: Every payment record links to a verified transaction with balance before/after verification.

### 📊 Budget Allocation & Cash Flow Analytics
- **Category Budgets**: Set spending limits across operational expenses, hosting, contractor fees, and personal drawings.
- **Real-Time Dashboards**: Interactive Chart.js visual breakdowns of cash flow velocity, profit margins, and monthly burn rate.

### 🛡️ Enterprise-Grade Security (OWASP Top 10)
- **Strict Tenant Isolation**: Schema-level and query-scope isolation preventing cross-tenant data leakage.
- **Audit Logging**: Comprehensive record of every financial alteration, import, and administrative override.

---

## 3. Technology Stack & Key Skills

- **Backend**: Laravel, PHP 8.2+, Eloquent ORM
- **Financial Logic**: Atomic database transactions, precision decimal handling, double-entry ledger principles
- **Database**: MySQL with indexing on date ranges, tenant identifiers, and transaction types
- **Frontend**: Blade, Bootstrap 5, Chart.js financial charts, dark/light theme tokens
- **Security Standards**: Rigorous alignment with OWASP Top 10 security practices

---

## 4. Key Engineering Highlights & Business Impact

- **Complex Financial Modeling**: Solved real cash reconciliation between physical wallets, local mobile money, and digital platforms.
- **High-Value Business Utility**: Demonstrates advanced business domain modeling, data integrity guarantees, and production SaaS architecture.
MD,
                'cover_image' => 'assets/img/projects/thubmnail6.png',
                'project_url' => null,
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel', 'MySQL', 'Multi-Tenancy', 'Chart.js', 'Bootstrap 5'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Laravel Portfolio CMS',
                'slug' => 'laravel-portfolio-cms',
                'summary' => 'Documentation-first personal portfolio and content management system with private admin CRUD, Bootstrap 5 design tokens, dynamic SEO engine, and zero-npm runtime.',
                'body' => <<<'MD'
## Overview

Laravel Portfolio CMS is a documentation-first web application built to serve as an authoritative personal brand platform and content management system. Eschewing heavy frontend frameworks, it uses native Laravel 12, Bootstrap 5 design tokens, and a clean single-admin control architecture.

---

## 1. Problem & Context

- **Static Portfolio Limitations**: Static site generators require code edits and Git commits for every minor text change, while off-the-shelf CMS solutions (WordPress) carry unnecessary bloat and security vulnerabilities.
- **Frontend Build Churn**: Many modern portfolios rely on complex Node/NPM build pipelines that break over time due to dependency deprecation.
- **Governance & Maintainability**: Personal projects frequently suffer from architectural drift and undocumented technical debt.

---

## 2. Core Features & Business Flows

### 🛠️ Comprehensive Admin CMS
- **Content CRUD**: Full administrative control over Projects, Case Studies, Work Experiences, Skills, Services, and Technical Blog Articles.
- **Resume Management**: Secure PDF upload, single-active versioning enforcement, and instant homepage download synchronization.
- **Contact Inbox with Telemetry**: In-app message inbox capturing visitor telemetry (IP address, user agent, timestamps) with unread badge alerts.

### 🚀 Built-In SEO & Extensible Sitemap
- **Admin SEO Control**: Customizable meta titles, descriptions, keywords, author attribution, and crawler visibility toggles directly from the settings panel.
- **Dynamic Robots & Sitemap**: Dynamically generated `robots.txt` and XML Sitemap 0.9 with extensible provider hooks ready for future routes.
- **Social Media Previews**: Automatic Open Graph (Facebook/LinkedIn) and Twitter Card tags tailored for each case study and blog post.

### 🎨 Tokenized Design System (No Build Step)
- **Zero-NPM Runtime**: Direct CSS custom properties (design tokens) loaded from `public/assets/`, completely eliminating npm build steps.
- **Instant Light/Dark Theme**: Fluid theme switcher utilizing native CSS variables with zero layout shift or flash of unstyled content.

---

## 3. Technology Stack & Key Skills

- **Backend**: Laravel 12, PHP 8.3, Form Request validation, Middleware security gates
- **Database**: MySQL with caching layers (`Setting::allCached()`) for instantaneous response times
- **Frontend**: Blade components, Bootstrap 5, Bootstrap Icons, Vanilla JS, Toastify notifications
- **Testing & Quality**: 38 automated PHPUnit/Pest tests (205 assertions) ensuring 100% regression safety

---

## 4. Key Engineering Highlights & Business Impact

- **Documentation-First Architecture**: Governed by an immutable Constitution, 17+ Architecture Decision Records (ADRs), and strict knowledge base standards before writing code.
- **Blazing-Fast Performance**: Achieved sub-50ms server response times through minimal database queries, setting caching, and direct asset delivery.
MD,
                'cover_image' => 'assets/img/projects/laravel.png',
                'project_url' => '/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel 12', 'MySQL', 'Bootstrap 5', 'Blade', 'PHPUnit'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 6,
            ],
            [
                'title' => 'Dev Toolkit',
                'slug' => 'dev-toolkit',
                'summary' => 'Public developer utilities suite featuring privacy-first client-side data transformations: JSON formatter, Base64 tools, image converters, and text diffing.',
                'body' => <<<'MD'
## Overview

Dev Toolkit is a focused web suite of developer utilities designed for day-to-day data transformations and formatting. Unlike cloud utility sites that transmit sensitive payloads to remote backends, Dev Toolkit prioritizes client-side privacy, processing developer data directly within the browser wherever feasible.

---

## 1. Problem & Context

- **Data Privacy Risks**: Developers pasting sensitive JSON payloads, API response tokens, or confidential database dumps into random online utility sites risk accidental data exfiltration.
- **Tab Bloat & Clutter**: Developers typically keep dozens of separate tabs open for simple utilities (Base64 encoder, JSON beautifier, diff checker, timestamp converter).

---

## 2. Core Features & Business Flows

### 🛠️ Developer Utility Modules
- **JSON Inspector & Formatter**: Syntax validation, indentation formatting, tree visualization, and minification.
- **Base64 & Cryptographic Encoders**: Instant two-way string and file Base64 encoding/decoding, URL encoding, and hash generators.
- **Text & Code Diff Checker**: Side-by-side visual diff comparisons highlighting added, modified, and deleted lines.
- **Image & PDF Utilities**: In-browser image resizing, compression, and file format conversions.

### 🔒 Privacy-First Design
- **Client-Side Execution**: Data transformations run via local JavaScript without transmitting sensitive payloads across external networks.

---

## 3. Technology Stack & Key Skills

- **Backend**: Laravel, Blade
- **Frontend**: JavaScript (Web APIs, File API, Canvas API), Bootstrap 5
- **Design Philosophy**: Minimalist, distraction-free interface optimized for fast keyboard navigation and clipboard pasting

---

## 4. Key Engineering Highlights & Business Impact

- **Utility & Adoption**: Built as a practical daily tool that directly demonstrates frontend JavaScript DOM proficiency and developer-centric UX design.
MD,
                'cover_image' => 'assets/img/projects/thumbnail1.png',
                'project_url' => 'https://devtoolkit.freedev.app/',
                'repo_url' => null,
                'video_url' => null,
                'tech_stack' => ['Laravel', 'JavaScript', 'Bootstrap 5', 'Blade'],
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 7,
            ],
        ];

        Project::query()
            ->where('slug', 'travel-and-tour')
            ->update(['slug' => 'km-explorer']);

        foreach ($projects as $projectData) {
            $existing = Project::where('slug', $projectData['slug'])->first();

            // Preserve user-uploaded cover image if present
            if ($existing && filled($existing->cover_image) && ! str_starts_with($existing->cover_image, 'assets/')) {
                unset($projectData['cover_image']);
            }

            // Preserve user-managed gallery if present
            if ($existing && $existing->hasGallery()) {
                unset($projectData['gallery']);
            }

            Project::updateOrCreate(['slug' => $projectData['slug']], $projectData);
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
            ['name' => 'n8n', 'category' => 'Tools', 'proficiency' => 4, 'sort_order' => 7, 'is_published' => true],
            ['name' => 'REST API', 'category' => 'Backend', 'proficiency' => 5, 'sort_order' => 8, 'is_published' => true],
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

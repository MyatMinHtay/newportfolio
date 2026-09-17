@extends('layouts.public')

@section('title', ($settings['site_title'] ?? 'Myat Min Htay — Full Stack Website Developer'))

@section('content')
    {{-- ==========================================
         HERO SECTION
         ========================================== --}}
    <section class="pf-page-section py-4 py-lg-5 mb-5" id="home">
        <div class="row align-items-center g-4 g-lg-5">
            {{-- Hero Left: Headlines, Pitch & CTAs --}}
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background-color: var(--pf-surface-muted); border: 1px solid var(--pf-border); font-size: 0.85rem;">
                    <span class="pf-status-dot"></span>
                    <span class="fw-medium" style="color: var(--pf-text);">{{ $settings['freelance_status'] ?? 'Available for Projects' }}</span>
                </div>

                <h1 class="display-4 fw-bolder lh-sm mb-3">
                    Hi, I'm <span style="color: var(--pf-primary);">{{ $settings['site_name'] ?? 'Myat Min Htay' }}</span><br>
                    <span class="fst-normal" style="font-size: 0.85em; color: var(--pf-text);">{{ $settings['hero_title'] ?? 'Full Stack Website Developer' }}</span>
                </h1>

                <p class="lead text-muted mb-4" style="max-width: 620px;">
                    {{ $settings['hero_subtitle'] ?? 'Production Laravel platforms, freelance product work, and maintainable admin systems.' }}
                </p>

                {{-- Action Buttons --}}
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <a href="#projects" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-grid me-2"></i> Explore Projects
                    </a>
                    <a href="#contact" class="btn btn-outline-secondary px-4 py-2">
                        <i class="bi bi-envelope me-2"></i> Get in Touch
                    </a>
                    @if($activeResume)
                        <a href="{{ asset($activeResume->file_path) }}" class="btn btn-outline-secondary px-3 py-2" target="_blank" download>
                            <i class="bi bi-download me-1"></i> Resume
                        </a>
                    @endif
                </div>

                {{-- Social Channels Links --}}
                <div class="d-flex align-items-center gap-2 pt-2">
                    <span class="small text-muted me-2">Connect:</span>
                    @if(!empty($socialLinks) && $socialLinks->count())
                        @foreach($socialLinks as $social)
                            <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="{{ $social->platform }}">
                                <i class="{{ $social->icon ?? 'bi bi-link-45deg' }}"></i>
                            </a>
                        @endforeach
                    @else
                        <a href="mailto:{{ $settings['contact_email'] ?? 'myatminhtay7@gmail.com' }}" class="btn btn-sm btn-outline-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Email">
                            <i class="bi bi-envelope"></i>
                        </a>
                        <a href="https://t.me/myatminhtay" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Telegram">
                            <i class="bi bi-telegram"></i>
                        </a>
                        <a href="https://github.com/myatminhtay" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="GitHub">
                            <i class="bi bi-github"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Hero Right: Developer Portrait with Badge --}}
            <div class="col-lg-5 text-center">
                <div class="pf-hero-avatar-wrapper">
                    <img src="{{ asset('assets/img/profile.png') }}" alt="{{ $settings['site_name'] ?? 'Myat Min Htay' }}" class="pf-hero-avatar img-fluid">
                    <div class="pf-hero-floating-badge">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background-color: var(--pf-primary-subtle); color: var(--pf-primary);">
                            <i class="bi bi-code-slash"></i>
                        </div>
                        <div class="text-start">
                            <div class="small fw-bold" style="color: var(--pf-text);">Full Stack</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Laravel &bull; MySQL &bull; AWS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==========================================
         BENTO HIGHLIGHT METRICS (Realtime Colors style)
         ========================================== --}}
    <section class="mb-5 pb-3">
        <div class="rc-bento-grid">
            <div class="rc-bento-card" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border);">
                <div>
                    <span class="badge mb-2" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">Track Record</span>
                    <div class="display-6 fw-bold" style="color: var(--pf-primary);">{{ $projects->count() }} Featured</div>
                </div>
                <p class="text-muted small mb-0">MorningStar, Dream Comic, KM Explorer, this CMS, and a Dev Toolkit preview.</p>
            </div>

            <div class="rc-bento-card" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border);">
                <div>
                    <span class="badge mb-2" style="background-color: rgba(71, 86, 107, 0.15); color: var(--pf-secondary);">Architecture</span>
                    <div class="display-6 fw-bold" style="color: var(--pf-text);">Full Stack</div>
                </div>
                    <p class="text-muted small mb-0">Laravel monoliths, MySQL, queues, AWS S3, Telegram, and production ops.</p>
            </div>

            <div class="rc-bento-card" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border);">
                <div>
                    <span class="badge mb-2" style="background-color: var(--pf-accent-subtle); color: var(--pf-accent);">Status</span>
                    <div class="display-6 fw-bold" style="color: var(--pf-accent);">Ready to Build</div>
                </div>
                <p class="text-muted small mb-0">Open for freelance contracts, team collaborations, and engineering roles.</p>
            </div>
        </div>
    </section>

    {{-- ==========================================
         FEATURED PROJECTS SHOWCASE
         ========================================== --}}
    <section class="pf-page-section py-5" id="projects">
        <div class="d-flex flex-column flex-md-row md-align-items-end justify-content-between mb-4 gap-3">
            <div>
                <span class="badge px-3 py-1 mb-2" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">Selected Work</span>
                <h2 class="h3 fw-bold mb-1">Production &amp; Freelance Projects</h2>
                <p class="text-muted mb-0">Laravel systems I own or shipped for clients. Full case studies will follow for each project.</p>
            </div>

            <div class="pf-filter-nav align-self-start align-self-md-end mb-0">
                <button type="button" class="pf-filter-btn active" data-filter="all">All ({{ $projects->count() }})</button>
                <button type="button" class="pf-filter-btn" data-filter="product">Product</button>
                <button type="button" class="pf-filter-btn" data-filter="freelance">Freelance</button>
                <button type="button" class="pf-filter-btn" data-filter="laravel">Laravel</button>
            </div>
        </div>

        <div class="row g-4" id="projectsGrid">
            @foreach($projects as $project)
                @php
                    $stack = is_array($project->tech_stack) ? $project->tech_stack : [];
                @endphp
                <div class="col-md-6 col-lg-4 project-item" data-category="{{ $project->filterTags() }}">
                    <div class="pf-project-card">
                        <div class="pf-project-thumb-box">
                            @if($project->hasCoverImage())
                                <img src="{{ $project->cover_image_url }}" alt="{{ $project->title }}" loading="lazy">
                            @else
                                <div class="pf-project-cover pf-project-cover--{{ $project->coverKey() }}">
                                    <i class="bi {{ $project->coverIcon() }}" aria-hidden="true"></i>
                                    <span>{{ $project->title }}</span>
                                </div>
                            @endif
                            @if($project->embed_url)
                                <div class="pf-project-video-overlay" role="button" data-bs-toggle="modal" data-bs-target="#projectVideoModal" data-video-url="{{ $project->embed_url }}" data-project-title="{{ $project->title }}" title="Watch Video Demo">
                                    <div class="pf-play-btn-circle">
                                        <i class="bi bi-play-fill" style="margin-left: 3px;"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="pf-project-body">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                <span class="pf-tech-pill">{{ $project->engagementLabel() }}</span>
                                @foreach(array_slice($stack, 0, 3) as $tech)
                                    <span class="pf-tech-pill">{{ $tech }}</span>
                                @endforeach
                            </div>

                            <h3 class="h5 fw-bold mb-2" style="color: var(--pf-text);">{{ $project->title }}</h3>
                            <p class="text-muted small mb-4 flex-grow-1">
                                {{ Str::limit($project->summary, 140) }}
                            </p>

                            <div class="pt-3 border-top d-flex align-items-center justify-content-between gap-2">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    @if($project->embed_url)
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#projectVideoModal" data-video-url="{{ $project->embed_url }}" data-project-title="{{ $project->title }}">
                                            <i class="bi bi-play-circle me-1"></i> Demo
                                        </button>
                                    @endif

                                    @if($project->project_url)
                                        <a
                                            href="{{ $project->isExternalUrl() ? $project->project_url : url($project->project_url) }}"
                                            class="btn btn-sm btn-primary"
                                            @if($project->isExternalUrl()) target="_blank" rel="noopener noreferrer" @endif
                                        >
                                            <i class="bi bi-box-arrow-up-right me-1"></i>
                                            {{ $project->isPreview() ? 'Preview' : ($project->isExternalUrl() ? 'Live' : 'This site') }}
                                        </a>
                                    @endif
                                </div>

                                <span class="small text-muted">Case study soon</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ==========================================
         SERVICES
         ========================================== --}}
    @if(isset($services) && $services->isNotEmpty())
        <section class="pf-page-section py-5" id="services">
            <div class="text-center mb-5">
                <span class="badge px-3 py-1 mb-2" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">What I offer</span>
                <h2 class="h3 fw-bold mb-2">Services</h2>
                <p class="text-muted" style="max-width: 640px; margin: 0 auto;">Laravel product work I take on — from shipping the app to keeping it running.</p>
            </div>

            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-md-6 col-lg-3">
                        <article class="pf-service-card h-100">
                            <div class="pf-service-icon" aria-hidden="true">
                                <i class="bi {{ $service->iconClass() }}"></i>
                            </div>
                            <h3 class="h5 fw-bold mb-2" style="color: var(--pf-text);">{{ $service->title }}</h3>
                            <p class="text-muted small mb-0">{{ $service->summary }}</p>
                        </article>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ==========================================
         SKILLS & TECH STACK
         ========================================== --}}
    <section class="pf-page-section py-5" id="skills">
        <div class="text-center mb-5">
            <span class="badge px-3 py-1 mb-2" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">Technical Skills</span>
            <h2 class="h3 fw-bold mb-2">Technologies &amp; Tools</h2>
            <p class="text-muted" style="max-width: 600px; margin: 0 auto;">Technologies and frameworks I have worked with to deliver scalable, performant software solutions.</p>
        </div>

        @if($skills->isNotEmpty())
            <div class="row g-4">
                @foreach($skills as $category => $categorySkills)
                    <div class="col-lg-6">
                        <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                <h3 class="h6 fw-bold text-uppercase tracking-wider mb-0" style="color: var(--pf-primary);">
                                    {{ $category }}
                                </h3>
                                <span class="badge rounded-pill" style="background-color: var(--pf-surface-muted); color: var(--pf-text-muted); border: 1px solid var(--pf-border);">
                                    {{ $categorySkills->count() }} Skills
                                </span>
                            </div>

                            <div class="row g-3">
                                @foreach($categorySkills as $skill)
                                    <div class="col-sm-6">
                                        <div class="pf-skill-card">
                                            <div class="pf-skill-icon-wrap">
                                                <img src="{{ $skill->icon_url }}" alt="{{ $skill->name }}" loading="lazy">
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <div class="fw-semibold text-truncate small" style="color: var(--pf-text);">{{ $skill->name }}</div>
                                                <div class="d-flex align-items-center gap-1 mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star-fill" style="font-size: 0.65rem; color: {{ $i <= ($skill->proficiency ?? 4) ? 'var(--pf-primary)' : 'var(--pf-border)' }};"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ==========================================
         EXPERIENCE & EDUCATION TIMELINE
         ========================================== --}}
    <section class="pf-page-section py-5" id="experience">
        <div class="row g-5">
            {{-- Timeline Column --}}
            <div class="col-lg-7">
                <span class="badge px-3 py-1 mb-2" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">Career Journey</span>
                <h2 class="h3 fw-bold mb-4">Experience &amp; Milestones</h2>

                <div class="pf-timeline">
                    @if(!empty($experiences) && $experiences->count())
                        @foreach($experiences as $exp)
                            <div class="pf-timeline-item {{ $loop->first ? 'highlight' : '' }}">
                                <div class="pf-timeline-dot"></div>
                                <div class="card p-3 border-0 shadow-sm" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-1">
                                        <h3 class="h6 fw-bold mb-0" style="color: var(--pf-text);">{{ $exp->role }}</h3>
                                        <span class="badge" style="background-color: var(--pf-surface-muted); color: var(--pf-text); border: 1px solid var(--pf-border);">
                                            {{ $exp->start_date ? $exp->start_date->format('M Y') . ' — ' . ($exp->end_date ? $exp->end_date->format('M Y') : 'Present') : 'Milestone' }}
                                        </span>
                                    </div>
                                    <div class="small fw-medium mb-2" style="color: var(--pf-primary);">{{ $exp->company }}</div>
                                    <p class="text-muted small mb-0">{{ $exp->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="pf-timeline-item highlight">
                            <div class="pf-timeline-dot"></div>
                            <div class="card p-3 border-0" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h3 class="h6 fw-bold mb-0">Grocery Sales POS System</h3>
                                    <span class="badge" style="background-color: var(--pf-surface-muted); color: var(--pf-text);">Freelance</span>
                                </div>
                                <div class="small fw-medium mb-2" style="color: var(--pf-primary);">Freelance POS Developer</div>
                                <p class="text-muted small mb-0">Contributed to business logic, transaction handling, barcode scanning integrations, and sales reports for retail grocery management.</p>
                            </div>
                        </div>

                        <div class="pf-timeline-item">
                            <div class="pf-timeline-dot"></div>
                            <div class="card p-3 border-0" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h3 class="h6 fw-bold mb-0">Startup Backend Developer Intern</h3>
                                    <span class="badge" style="background-color: var(--pf-surface-muted); color: var(--pf-text);">Internship</span>
                                </div>
                                <div class="small fw-medium mb-2" style="color: var(--pf-primary);">Tech Startup</div>
                                <p class="text-muted small mb-0">Built backend API endpoints, worked with relational databases, and collaborated in team sprint cycles.</p>
                            </div>
                        </div>

                        <div class="pf-timeline-item">
                            <div class="pf-timeline-dot"></div>
                            <div class="card p-3 border-0" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h3 class="h6 fw-bold mb-0">DataLand Technology (WDF)</h3>
                                    <span class="badge" style="background-color: var(--pf-surface-muted); color: var(--pf-text);">Training</span>
                                </div>
                                <div class="small fw-medium mb-2" style="color: var(--pf-primary);">Web Development Foundation</div>
                                <p class="text-muted small mb-0">Intensive curriculum covering frontend styling, JavaScript programming, and full-stack software lifecycle.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Engineering Values / About Sidebar --}}
            <div class="col-lg-5" id="about">
                <span class="badge px-3 py-1 mb-2" style="background-color: var(--pf-accent-subtle); color: var(--pf-accent);">Philosophy</span>
                <h2 class="h3 fw-bold mb-4">Engineering Values</h2>

                <div class="card p-4 border-0 shadow-sm mb-4" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: var(--pf-primary-subtle); color: var(--pf-primary); flex-shrink: 0;">
                            <i class="bi bi-layers fs-5"></i>
                        </div>
                        <div>
                            <h3 class="h6 fw-bold mb-1">Clean &amp; Maintainable Code</h3>
                            <p class="text-muted small mb-0">Adhering to SOLID principles, clear separation of concerns, and robust database migrations.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center pf-channel-icon is-secondary" style="width: 42px; height: 42px; flex-shrink: 0;">
                            <i class="bi bi-speedometer2 fs-5"></i>
                        </div>
                        <div>
                            <h3 class="h6 fw-bold mb-1">High Performance &amp; Security</h3>
                            <p class="text-muted small mb-0">Optimized queries, CSRF &amp; rate limit guards, and minimal bundle sizes without unnecessary bloat.</p>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: var(--pf-accent-subtle); color: var(--pf-accent); flex-shrink: 0;">
                            <i class="bi bi-arrow-repeat fs-5"></i>
                        </div>
                        <div>
                            <h3 class="h6 fw-bold mb-1">Continuous Learning</h3>
                            <p class="text-muted small mb-0">Started coding in 2018, expanding across Laravel, production operations, Linux basics, and API integrations.</p>
                        </div>
                    </div>
                </div>

                {{-- Personal Bio Details --}}
                <div class="card p-4 border-0 shadow-sm" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                    <h3 class="h6 fw-bold mb-3" style="color: var(--pf-text);">Quick Facts</h3>
                    <ul class="list-unstyled small mb-0 text-muted d-flex flex-column gap-2">
                        <li class="d-flex justify-content-between">
                            <span class="fw-medium text-body">Location:</span>
                            <span>{{ $settings['contact_location'] ?? 'Mandalay, Myanmar' }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="fw-medium text-body">Education:</span>
                            <span>{{ $settings['education'] ?? '2nd year in physics (YDNB)' }}</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="fw-medium text-body">Languages:</span>
                            <span>Burmese (Native), English</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span class="fw-medium text-body">Freelance:</span>
                            <span class="text-success fw-bold">Available for Hire</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ==========================================
         CONTACT SECTION
         ========================================== --}}
    <section class="pf-page-section py-5" id="contact">
        <div class="text-center mb-5">
            <span class="badge px-3 py-1 mb-2" style="background-color: var(--pf-primary-subtle); color: var(--pf-primary);">Get In Touch</span>
            <h2 class="h3 fw-bold mb-2">Let's Work Together</h2>
            <p class="text-muted" style="max-width: 580px; margin: 0 auto;">Have an interesting project, question, or looking for a developer? Feel free to message me directly.</p>
        </div>

        <div class="row g-4 justify-content-center">
            {{-- Contact Information Cards --}}
            <div class="col-lg-5">
                <div class="d-flex flex-column gap-3">
                    <a href="mailto:{{ $settings['contact_email'] ?? 'myatminhtay7@gmail.com' }}" class="pf-contact-channel">
                        <div class="pf-channel-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Email Me</div>
                            <div class="fw-semibold">{{ $settings['contact_email'] ?? 'myatminhtay7@gmail.com' }}</div>
                        </div>
                    </a>

                    <a href="tel:{{ $settings['contact_phone'] ?? '09266216485' }}" class="pf-contact-channel">
                        <div class="pf-channel-icon is-secondary">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Direct Call</div>
                            <div class="fw-semibold">{{ $settings['contact_phone'] ?? '09266216485' }}</div>
                        </div>
                    </a>

                    <a href="https://t.me/myatminhtay" target="_blank" rel="noopener noreferrer" class="pf-contact-channel">
                        <div class="pf-channel-icon is-accent">
                            <i class="bi bi-telegram"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Telegram Chat</div>
                            <div class="fw-semibold">@myatminhtay</div>
                        </div>
                    </a>

                    <div class="pf-contact-channel">
                        <div class="pf-channel-icon is-muted">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Location</div>
                            <div class="fw-semibold">{{ $settings['contact_location'] ?? 'Mandalay, Myanmar' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Interactive Contact Message Form --}}
            <div class="col-lg-7">
                <div class="card p-4 p-md-5 border-0 shadow-sm" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                    <form id="portfolioContactForm" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="contact_name" class="form-label small fw-semibold">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="contact_name" name="name" placeholder="John Doe" required maxlength="100">
                            </div>

                            <div class="col-md-6">
                                <label for="contact_email" class="form-label small fw-semibold">Your Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="contact_email" name="email" placeholder="john@example.com" required maxlength="150">
                            </div>

                            <div class="col-12">
                                <label for="contact_subject" class="form-label small fw-semibold">Subject</label>
                                <input type="text" class="form-control" id="contact_subject" name="subject" placeholder="Project Inquiry / Job Opportunity" maxlength="200">
                            </div>

                            <div class="col-12">
                                <label for="contact_message" class="form-label small fw-semibold">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="contact_message" name="message" rows="5" placeholder="Tell me about your project details or inquiries..." required maxlength="5000"></textarea>
                            </div>

                            <div class="col-12 pt-2">
                                <button type="submit" id="contactSubmitBtn" class="btn btn-primary px-4 py-2 w-100">
                                    <i class="bi bi-send me-2"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- ==========================================
         VIDEO DEMO MODAL (Vimeo / YouTube Player)
         ========================================== --}}
    <div class="modal fade" id="projectVideoModal" tabindex="-1" aria-labelledby="projectVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="background-color: var(--pf-surface); border: 1px solid var(--pf-border) !important;">
                <div class="modal-header border-bottom py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-play-circle-fill text-primary fs-5"></i>
                        <h3 class="modal-title h6 fw-bold mb-0" id="projectVideoModalLabel">Project Video Demo</h3>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9" style="background-color: #000;">
                        <iframe id="projectVideoIframe" src="" title="Video Player" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Projects Category Filtering
        const filterButtons = document.querySelectorAll('.pf-filter-btn');
        const projectItems = document.querySelectorAll('.project-item');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                projectItems.forEach(item => {
                    const categories = item.getAttribute('data-category') || '';
                    if (filter === 'all' || categories.includes(filter)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // 2. Video Modal Player Handling
        const videoModalEl = document.getElementById('projectVideoModal');
        const videoIframe = document.getElementById('projectVideoIframe');
        const videoTitle = document.getElementById('projectVideoModalLabel');

        if (videoModalEl) {
            videoModalEl.addEventListener('show.bs.modal', function (event) {
                const triggerBtn = event.relatedTarget;
                if (!triggerBtn) return;

                const url = triggerBtn.getAttribute('data-video-url');
                const title = triggerBtn.getAttribute('data-project-title');

                if (title && videoTitle) {
                    videoTitle.textContent = title + ' — Video Demo';
                }

                if (url && videoIframe) {
                    // Autoplay video on load if supported
                    const finalUrl = url.includes('?') ? url + '&autoplay=1' : url + '?autoplay=1';
                    videoIframe.src = finalUrl;
                }
            });

            videoModalEl.addEventListener('hide.bs.modal', function () {
                // Clear iframe src to stop playback
                if (videoIframe) {
                    videoIframe.src = '';
                }
            });
        }

        // 3. Interactive Contact Form Submission via AJAX
        const contactForm = document.getElementById('portfolioContactForm');
        const submitBtn = document.getElementById('contactSubmitBtn');

        if (contactForm && submitBtn) {
            contactForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Sending...';

                const formData = new FormData(contactForm);

                try {
                    const response = await fetch(contactForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        if (typeof showToast === 'function') {
                            showToast(data.message || 'Message sent successfully!', 'success');
                        } else {
                            alert(data.message || 'Message sent successfully!');
                        }
                        contactForm.reset();
                    } else {
                        const errMsg = data.message || 'Validation failed. Please check your input fields.';
                        if (typeof showToast === 'function') {
                            showToast(errMsg, 'error');
                        } else {
                            alert(errMsg);
                        }
                    }
                } catch (err) {
                    console.error('Contact submit error:', err);
                    if (typeof showToast === 'function') {
                        showToast('Failed to send message. Please try again or email directly.', 'error');
                    } else {
                        alert('Failed to send message. Please email directly.');
                    }
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });
        }
    });
</script>
@endpush

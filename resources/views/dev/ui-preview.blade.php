@extends('layouts.public')

@section('title', 'Realtime Colors Style — UI Preview')

@section('content')
    {{-- Top Realtime Colors Floating Banner --}}
    <div class="mb-4 pb-2 d-flex flex-wrap align-items-center justify-content-between gap-3 border-bottom">
        <div class="d-flex align-items-center gap-2">
            <span class="badge" style="background-color: var(--pf-primary); color: #fff;">UI Preview</span>
            <span class="small text-muted">Realtime Colors Style Mockup &bull; Fully Interactive</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.setTheme('light')">
                <i class="bi bi-sun me-1"></i> Light
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.setTheme('dark')">
                <i class="bi bi-moon-stars me-1"></i> Dark
            </button>
            <a href="{{ route('admin.home') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-speedometer2 me-1"></i> Admin CMS
            </a>
        </div>
    </div>

    {{-- HERO SECTION --}}
    <section class="py-4 py-lg-5 mb-5">
        <div class="row align-items-center g-4 g-lg-5">
            {{-- Hero Left: Headlines & Toolbar --}}
            <div class="col-lg-7">
                <h1 class="display-4 fw-bolder lh-sm mb-3">
                    Visualize Your <span style="color: var(--pf-primary);">Colors</span> &amp; <span class="fst-italic text-decoration-underline" style="text-decoration-color: var(--pf-accent) !important;">Fonts</span><br>On a Real Site
                </h1>
                <p class="lead text-muted mb-4" style="max-width: 580px;">
                    Watch your portfolio palette and components come to life on a real page with real interactive elements and clean Bootstrap layout.
                </p>

                {{-- Realtime Colors Style Palette Bar --}}
                <div class="rc-toolbar mb-4">
                    <div class="rc-chip">
                        <span class="rc-chip-swatch" style="background-color: var(--pf-text);"></span>
                        <span>Text</span>
                    </div>
                    <div class="rc-chip">
                        <span class="rc-chip-swatch" style="background-color: var(--pf-bg);"></span>
                        <span>Background</span>
                    </div>
                    <div class="rc-chip">
                        <span class="rc-chip-swatch" style="background-color: var(--pf-primary);"></span>
                        <span>Primary</span>
                    </div>
                    <div class="rc-chip">
                        <span class="rc-chip-swatch" style="background-color: var(--pf-secondary);"></span>
                        <span>Secondary</span>
                    </div>
                    <div class="rc-chip">
                        <span class="rc-chip-swatch" style="background-color: var(--pf-accent);"></span>
                        <span>Accent</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 theme-toggle" title="Switch Light/Dark Mode">
                        <i class="bi bi-moon-stars"></i>
                    </button>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <button type="button" class="btn btn-primary px-4 py-2" onclick="showToast('Get Started clicked!', 'info')">
                        Get Started
                    </button>
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="document.getElementById('features').scrollIntoView({behavior: 'smooth'})">
                        How It Works
                    </button>
                </div>
            </div>

            {{-- Hero Right: Geometric Artwork Mockup --}}
            <div class="col-lg-5">
                <div class="rc-hero-graphic">
                    <div style="width: 100%; max-width: 380px; height: 320px; position: relative; background: var(--pf-surface-muted); border-radius: 1rem; overflow: hidden; border: 1px solid var(--pf-border); padding: 1.25rem;">
                        {{-- Geometric Abstract Shapes replicating the screenshot --}}
                        <div style="position: absolute; top: 1.5rem; left: 1.5rem; width: 55%; height: 60%; background-color: var(--pf-primary); border-radius: 1rem; box-shadow: var(--pf-shadow-md);"></div>
                        <div style="position: absolute; top: 1.5rem; right: 1.5rem; width: 32%; height: 35%; background-color: var(--pf-secondary); border-radius: 0.75rem;"></div>
                        <div style="position: absolute; bottom: 1.5rem; left: 1.5rem; width: 35%; height: 25%; background-color: var(--pf-text); border-radius: 0.75rem;"></div>
                        <div style="position: absolute; bottom: 1.5rem; right: 1.5rem; width: 48%; height: 25%; background-color: var(--pf-accent); border-radius: 0.75rem;"></div>
                        <div style="position: absolute; top: 45%; right: 1.5rem; width: 32%; height: 18%; background-color: var(--pf-surface); border: 1px solid var(--pf-border); border-radius: 0.5rem;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: WHY REALTIME COLORS? (3 CARDS) --}}
    <section class="py-5" id="features">
        <div class="text-center mb-5">
            <h2 class="h3 fw-bold mb-2">Why Realtime Colors?</h2>
            <p class="text-muted">A dedicated design preview ensuring accessible contrast and harmonious palette balance.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface);">
                    <div class="rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px; background-color: var(--pf-primary-subtle); color: var(--pf-primary);">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Saves Time</h3>
                    <p class="text-muted mb-0">No more guessing how colors look together. Preview every single component in real time before building.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface);">
                    <div class="rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px; background-color: rgba(71, 86, 107, 0.15); color: var(--pf-secondary);">
                        <i class="bi bi-grid-1x2 fs-4"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">It's Realistic</h3>
                    <p class="text-muted mb-0">See your colors in action on a real website layout with real cards, accordions, buttons, and tables.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface);">
                    <div class="rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 52px; height: 52px; background-color: var(--pf-accent-subtle); color: var(--pf-accent);">
                        <i class="bi bi-laptop fs-4"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">It's Simple</h3>
                    <p class="text-muted mb-0">Clean Bootstrap 5 layout semantics with zero heavy UI libraries or unnecessary JavaScript bloat.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: BENTO GRID STATS --}}
    <section class="py-5" id="bento">
        <div class="row g-3">
            {{-- Big Primary Block --}}
            <div class="col-lg-8">
                <div class="rc-bento-card text-white h-100" style="background-color: var(--pf-primary); min-height: 200px;">
                    <div>
                        <span class="badge text-bg-light text-primary fw-bold mb-3">Portfolio Highlights</span>
                        <h2 class="display-4 fw-bolder mb-2">9+ Live Projects</h2>
                    </div>
                    <p class="lead mb-0 text-white-50">Web apps, REST APIs, and interactive systems seeded directly from Old Portfolio.</p>
                </div>
            </div>

            {{-- Secondary Neutral Block --}}
            <div class="col-lg-4">
                <div class="rc-bento-card text-white h-100" style="background-color: var(--pf-secondary); min-height: 200px;">
                    <div>
                        <span class="badge bg-white bg-opacity-25 text-white mb-3">Open Architecture</span>
                        <h3 class="display-6 fw-bold mb-1">100% Free!</h3>
                    </div>
                    <p class="small text-white-50 mb-0">Laravel 12 Native first &bull; No Tailwind &bull; No bloated dependencies.</p>
                </div>
            </div>

            {{-- Text/Dark Contrast Block --}}
            <div class="col-lg-5">
                <div class="rc-bento-card h-100" style="background-color: var(--pf-text); color: var(--pf-bg); min-height: 160px;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle p-3" style="background: rgba(255,255,255,0.1); color: var(--pf-accent);">
                            <i class="bi bi-terminal fs-2"></i>
                        </div>
                        <div>
                            <h4 class="h5 fw-bold mb-1">Developer Scripts Hub</h4>
                            <p class="small opacity-75 mb-0">Custom automation tools and open snippets.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Accent Cyan Block --}}
            <div class="col-lg-7">
                <div class="rc-bento-card h-100" style="background-color: var(--pf-accent); color: #030507; min-height: 160px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="h4 fw-bold mb-1">#1 Personal Portfolio Renewal</h4>
                            <p class="mb-0 small fw-medium opacity-75">Engineered for speed, SEO, and maintainable simplicity.</p>
                        </div>
                        <i class="bi bi-trophy fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: HOW DOES IT WORK? --}}
    <section class="py-5" id="how-it-works">
        <div class="card p-4 p-lg-5 border-0 shadow-sm" style="background-color: var(--pf-surface);">
            <div class="row align-items-center g-4">
                <div class="col-lg-5">
                    <h2 class="h3 fw-bold mb-3">How Does It Work?</h2>
                    <p class="text-muted mb-4">
                        A streamlined 4-step workflow to curate, customize, and publish your portfolio with total confidence.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Access Admin Panel <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="d-flex gap-3">
                                <span class="fw-bolder fs-3" style="color: var(--pf-primary);">1</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1">Pick your palette</h4>
                                    <p class="small text-muted mb-0">Lock your primary, secondary, and accent colors in tokens.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="d-flex gap-3">
                                <span class="fw-bolder fs-3" style="color: var(--pf-secondary);">2</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1">Preview in Real-Time</h4>
                                    <p class="small text-muted mb-0">Switch between light and dark themes instantly.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="d-flex gap-3">
                                <span class="fw-bolder fs-3" style="color: var(--pf-accent);">3</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1">Manage Case Studies</h4>
                                    <p class="small text-muted mb-0">Add demo links, videos, and tech stacks in Admin CMS.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="d-flex gap-3">
                                <span class="fw-bolder fs-3" style="color: var(--pf-primary);">4</span>
                                <div>
                                    <h4 class="h6 fw-bold mb-1">Deploy smoothly</h4>
                                    <p class="small text-muted mb-0">Production-ready Laravel with zero frontend build complexity.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: PLANS & PRICING (3 CARDS) --}}
    <section class="py-5" id="pricing">
        <div class="text-center mb-5">
            <h2 class="h3 fw-bold mb-2">Plans &amp; Pricing</h2>
            <p class="text-muted">Structured packages for freelance, startup collaboration, and full-stack contracts.</p>
        </div>

        <div class="row g-4 align-items-stretch">
            {{-- Basic Card --}}
            <div class="col-lg-4">
                <div class="card h-100 p-4 border-0 shadow-sm d-flex flex-column justify-content-between" style="background-color: var(--pf-surface);">
                    <div>
                        <h3 class="h5 fw-bold mb-1">Basic</h3>
                        <p class="text-muted small mb-3">For simple landing pages and static sites.</p>
                        <div class="display-6 fw-bold mb-4">$250 <span class="fs-6 text-muted fw-normal">/ project</span></div>

                        <ul class="list-unstyled mb-4 small d-flex flex-column gap-2">
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-accent);"></i> 1 Single-Page Landing</li>
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-accent);"></i> Fully Responsive Bootstrap 5</li>
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-accent);"></i> Contact Form Integration</li>
                            <li class="text-muted text-decoration-line-through"><i class="bi bi-dash-circle me-2"></i> Custom Admin CMS</li>
                        </ul>
                    </div>

                    <button type="button" class="btn btn-outline-secondary w-100" onclick="showToast('Selected Basic tier', 'info')">
                        Choose Basic
                    </button>
                </div>
            </div>

            {{-- Pro Card (Featured / Highlighted) --}}
            <div class="col-lg-4">
                <div class="card h-100 p-4 shadow-sm position-relative d-flex flex-column justify-content-between" style="background-color: var(--pf-surface); border: 2px solid var(--pf-primary) !important;">
                    <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill px-3 py-2" style="background-color: var(--pf-primary); color: #fff;">
                        Most Popular
                    </span>

                    <div>
                        <h3 class="h5 fw-bold mb-1 text-primary">Pro</h3>
                        <p class="text-muted small mb-3">Custom Portfolio &amp; Content Management CMS.</p>
                        <div class="display-6 fw-bold mb-4">$600 <span class="fs-6 text-muted fw-normal">/ project</span></div>

                        <ul class="list-unstyled mb-4 small d-flex flex-column gap-2">
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-primary);"></i> Multi-Page Portfolio Website</li>
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-primary);"></i> Private Admin Panel &amp; Auth</li>
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-primary);"></i> Project Case Studies &amp; Demos</li>
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-primary);"></i> Light &amp; Dark Theme Support</li>
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-primary);"></i> Gmail SMTP Notifications</li>
                        </ul>
                    </div>

                    <button type="button" class="btn btn-primary w-100 py-2 fw-semibold" onclick="showToast('Selected Pro tier!', 'success')">
                        Get Started Pro
                    </button>
                </div>
            </div>

            {{-- Enterprise Card --}}
            <div class="col-lg-4">
                <div class="card h-100 p-4 border-0 shadow-sm d-flex flex-column justify-content-between" style="background-color: var(--pf-surface);">
                    <div>
                        <h3 class="h5 fw-bold mb-1">Enterprise</h3>
                        <p class="text-muted small mb-3">Full-scale web apps, API architecture &amp; databases.</p>
                        <div class="display-6 fw-bold mb-4">Custom <span class="fs-6 text-muted fw-normal">/ contract</span></div>

                        <ul class="list-unstyled mb-4 small d-flex flex-column gap-2">
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-secondary);"></i> Laravel &amp; MySQL Backend Systems</li>
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-secondary);"></i> REST APIs for Mobile Apps</li>
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-secondary);"></i> Payment &amp; Coin System Integration</li>
                            <li><i class="bi bi-check-circle-fill me-2" style="color: var(--pf-secondary);"></i> Ongoing Maintenance &amp; Scaling</li>
                        </ul>
                    </div>

                    <button type="button" class="btn btn-outline-secondary w-100" onclick="showToast('Contacting Enterprise', 'info')">
                        Contact Me
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: TESTIMONIALS (3 CARDS) --}}
    <section class="py-5" id="testimonials">
        <div class="text-center mb-5">
            <h2 class="h3 fw-bold mb-2">Testimonials</h2>
            <p class="text-muted">Feedback from colleagues, project owners, and tech leads.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 44px; height: 44px; background-color: var(--pf-primary);">
                            AP
                        </div>
                        <div>
                            <h4 class="h6 fw-bold mb-0">AMZ Studio Lead</h4>
                            <span class="small text-muted">Creative Director</span>
                        </div>
                    </div>
                    <div class="mb-3" style="color: var(--pf-accent);">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="small text-muted mb-0">"Myat Min Htay delivered our photo studio website with crisp responsiveness and quick turnaround time."</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface);">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 44px; height: 44px; background-color: var(--pf-secondary);">
                            DL
                        </div>
                        <div>
                            <h4 class="h6 fw-bold mb-0">DataLand Mentor</h4>
                            <span class="small text-muted">Senior Instructor</span>
                        </div>
                    </div>
                    <div class="mb-3" style="color: var(--pf-accent);">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="small text-muted mb-0">"Strong foundation in PHP and Laravel fundamentals. Excellent discipline in clean code architecture."</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface);">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold mb-3" style="width: 44px; height: 44px; background-color: var(--pf-accent); color: #030507 !important;">
                        FS
                    </div>
                    <div>
                        <h4 class="h6 fw-bold mb-0">POS Client</h4>
                        <span class="small text-muted">Business Owner</span>
                    </div>
                    <div class="mb-3 mt-1" style="color: var(--pf-accent);">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <p class="small text-muted mb-0">"The Grocery Sales POS system handled our inventory tracking effortlessly. Highly dependable full stack developer."</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: FAQ --}}
    <section class="py-5" id="faq">
        <div class="row g-4">
            <div class="col-lg-5">
                <h2 class="h3 fw-bold mb-2">Frequently Asked Questions</h2>
                <p class="text-muted">Answers regarding our tech stack, theme system, and architecture.</p>
            </div>

            <div class="col-lg-7">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeadingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne">
                                How does the Light/Dark theme switching work?
                            </button>
                        </h2>
                        <div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small">
                                It uses native CSS custom properties applied via <code>[data-bs-theme="dark"]</code> attribute. The selected theme is stored in <code>localStorage</code> with zero page flash on reload.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeadingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo">
                                Why is Bootstrap used purely for layout?
                            </button>
                        </h2>
                        <div id="faqOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small">
                                Bootstrap provides a solid, time-tested responsive grid and accessible utility classes. All visual colors, buttons, and surfaces are cleanly overwritten with custom CSS tokens.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeadingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree">
                                Where are the portfolio projects stored?
                            </button>
                        </h2>
                        <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small">
                                All 9 projects from the legacy portfolio are seeded in the MySQL database, with support for live demo links, Vimeo video embeds, and Markdown case studies.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: FEATURED ARTICLES --}}
    <section class="py-5" id="articles">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h3 fw-bold mb-1">Featured Articles</h2>
                <p class="text-muted small mb-0">Insights on Laravel architecture and modern web design.</p>
            </div>
            <span class="badge text-bg-light border text-muted">Blog Hub</span>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface);">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2 align-self-start">Architecture</span>
                    <h3 class="h6 fw-bold mb-2">Building a Clean Personal CMS in Laravel 12</h3>
                    <p class="small text-muted mb-0">Why convention-over-configuration and native tools outlast complex framework stacks.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface);">
                    <span class="badge bg-secondary bg-opacity-10 text-secondary mb-2 align-self-start">Design Systems</span>
                    <h3 class="h6 fw-bold mb-2">Decoupling Layout from Colors in Bootstrap 5</h3>
                    <p class="small text-muted mb-0">How CSS variables allow high-contrast dual themes without fighting Bootstrap styles.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 p-4 border-0 shadow-sm" style="background-color: var(--pf-surface);">
                    <span class="badge bg-info bg-opacity-10 text-info mb-2 align-self-start">Best Practices</span>
                    <h3 class="h6 fw-bold mb-2">Case Study Engineering for Developer Portfolios</h3>
                    <p class="small text-muted mb-0">Structure real problems, video walkthroughs, and architecture diagrams that hire managers love.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FINAL CALL TO ACTION BANNER --}}
    <section class="my-5 py-5 text-center card p-4 p-lg-5 border-0 shadow-sm" style="background-color: var(--pf-surface);">
        <h2 class="display-6 fw-bold mb-3">
            Your <span style="color: var(--pf-primary);">Journey</span> Shouldn't End Here.
        </h2>
        <p class="text-muted mx-auto mb-4" style="max-width: 520px;">
            Let's collaborate on your next full-stack web project or explore custom case studies.
        </p>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('admin.home') }}" class="btn btn-primary px-4 py-2">
                Open Dashboard
            </a>
            <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="showToast('Contact channel ready!', 'info')">
                Contact Me
            </button>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function showToast(message, type) {
        if (typeof Toastify === 'undefined') {
            alert(message);
            return;
        }

        let bg = 'var(--pf-primary)';
        if (type === 'success') bg = 'var(--pf-success)';
        if (type === 'error') bg = 'var(--pf-danger)';
        if (type === 'warning') bg = 'var(--pf-warning)';
        if (type === 'info') bg = 'var(--pf-accent)';

        Toastify({
            text: message,
            duration: 3500,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: bg,
                color: (type === 'info') ? '#030507' : '#ffffff',
                borderRadius: "var(--pf-radius)",
                boxShadow: "var(--pf-shadow-md)",
                fontWeight: "500"
            }
        }).showToast();
    }
</script>
@endpush

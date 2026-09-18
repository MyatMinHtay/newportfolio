<nav class="navbar navbar-expand-lg sticky-top pf-public-nav" style="background-color: var(--pf-surface);" aria-label="Primary">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold" href="{{ url('/') }}#home">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="32" height="32" class="rounded" onerror="this.style.display='none'">
            <span>{{ project('site_name', 'Myat Min Htay') }}</span>
            <span class="d-none d-sm-inline-flex align-items-center gap-1 badge rounded-pill ms-1" style="background-color: var(--pf-surface-muted); color: var(--pf-text); border: 1px solid var(--pf-border); font-size: 0.75rem; font-weight: 500;">
                <span class="pf-status-dot"></span>
                <span>Available</span>
            </span>
        </a>

        <button
            class="navbar-toggler border-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#publicNav"
            aria-controls="publicNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="publicNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#projects">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#skills">Skills</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#experience">Experience</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog.index') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a href="#contact" class="btn btn-outline-secondary btn-sm px-3 rounded-pill">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> Resume
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-circle theme-toggle" title="Toggle Light / Dark theme" aria-label="Toggle Light / Dark theme">
                        <i class="bi bi-moon-stars" aria-hidden="true"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

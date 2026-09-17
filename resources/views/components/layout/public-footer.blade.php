<footer class="pf-public-footer py-4 border-top" style="background-color: var(--pf-surface);">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="24" height="24" class="rounded" onerror="this.style.display='none'">
                <span class="fw-semibold" style="color: var(--pf-text);">{{ project('site_name', 'Myat Min Htay') }}</span>
                <span class="text-muted small">&bull; &copy; {{ date('Y') }} All rights reserved.</span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="#home" class="small text-decoration-none text-muted" style="transition: color var(--pf-duration);">
                    <i class="bi bi-arrow-up-circle me-1"></i> Back to Top
                </a>
                <span class="text-muted small">&bull;</span>
                <a href="{{ route('admin.home') }}" class="small text-decoration-none text-muted">
                    <i class="bi bi-lock me-1"></i> Admin CMS
                </a>
            </div>
        </div>
    </div>
</footer>

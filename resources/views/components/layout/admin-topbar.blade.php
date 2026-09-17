<header class="pf-admin-topbar px-3 px-md-4 py-3 d-flex align-items-center justify-content-between gap-3">
    <div class="d-flex align-items-center gap-2">
        <button
            class="btn btn-outline-secondary btn-sm d-md-none"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#adminOffcanvas"
            aria-controls="adminOffcanvas"
            aria-label="Open menu"
        >
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>
        <span class="text-muted small">@yield('topbar', 'Top navigation placeholder')</span>
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="button" class="btn btn-outline-secondary btn-sm theme-toggle" title="Toggle Light / Dark theme">
            <i class="bi bi-moon-stars" aria-hidden="true"></i>
        </button>
        @auth
            <span class="small fw-semibold">
                <i class="bi bi-person-circle me-1" aria-hidden="true"></i>
                {{ Auth::user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right me-1" aria-hidden="true"></i> Logout
                </button>
            </form>
        @else
            <div class="small text-muted">
                <i class="bi bi-person-circle me-1" aria-hidden="true"></i>
                User menu placeholder
            </div>
        @endauth
    </div>
</header>

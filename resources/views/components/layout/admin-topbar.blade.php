<header class="pf-admin-topbar px-3 px-md-4 py-2 py-md-3 d-flex align-items-center justify-content-between gap-2">
    <div class="d-flex align-items-center gap-2 min-w-0">
        <button
            class="btn btn-outline-secondary btn-sm d-md-none flex-shrink-0"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#adminOffcanvas"
            aria-controls="adminOffcanvas"
            aria-label="Open menu"
        >
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>
        <span class="fw-bold small d-md-none text-body text-truncate">
            Portfolio CMS
        </span>
        <div class="d-none d-md-flex align-items-center gap-2">
            @hasSection('topbar')
                <span class="text-muted small">@yield('topbar')</span>
            @else
                <a href="{{ url('/') }}" target="_blank" class="text-muted small text-decoration-none d-inline-flex align-items-center gap-1">
                    <i class="bi bi-box-arrow-up-right"></i> View public site
                </a>
            @endif
        </div>
    </div>

    <div class="d-flex align-items-center gap-2 flex-shrink-0">
        <button type="button" class="btn btn-outline-secondary btn-sm theme-toggle" title="Toggle Light / Dark theme">
            <i class="bi bi-moon-stars" aria-hidden="true"></i>
        </button>

        @auth
            <div class="dropdown">
                <button
                    class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center"
                    type="button"
                    id="adminUserDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <i class="bi bi-person-circle" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline fw-medium small ms-1">{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="adminUserDropdown" style="min-width: 200px;">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-bold small text-truncate">{{ Auth::user()->name }}</div>
                        <div class="text-muted small text-truncate">{{ Auth::user()->email }}</div>
                    </li>
                    <li>
                        <a class="dropdown-item small py-2 d-flex align-items-center" href="{{ url('/') }}" target="_blank">
                            <i class="bi bi-globe me-2 text-muted"></i> Live Website
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item small py-2 d-flex align-items-center" href="{{ route('admin.settings.index') }}">
                            <i class="bi bi-gear me-2 text-muted"></i> Settings
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item small py-2 text-danger d-flex align-items-center">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
        @endauth
    </div>
</header>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ project('site_name', 'Portfolio') }} CMS</title>
    <x-layout.assets-head />
    @stack('head')
</head>
<body>
    <div class="pf-admin-shell">
        <div class="d-none d-md-block">
            <x-layout.admin-sidebar />
        </div>

        {{-- Mobile offcanvas sidebar --}}
        <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="adminOffcanvas" aria-labelledby="adminOffcanvasLabel">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title h5" id="adminOffcanvasLabel">Admin</h2>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <x-navigation.admin-nav />
            </div>
        </div>

        <div class="pf-admin-main">
            <x-layout.admin-topbar />

            <div class="pf-admin-content">
                @hasSection('breadcrumb')
                    @yield('breadcrumb')
                @endif

                <x-layout.flash />

                @yield('content')
            </div>

            <x-layout.admin-footer />
        </div>
    </div>

    <x-layout.assets-scripts />
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sign in') — {{ project('site_name', 'Portfolio') }}</title>
    <x-layout.assets-head />
    @stack('head')
</head>
<body class="d-flex align-items-center min-vh-100">
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <x-layout.flash />
                @yield('content')
            </div>
        </div>
    </main>

    <x-layout.assets-scripts />
    @stack('scripts')
</body>
</html>

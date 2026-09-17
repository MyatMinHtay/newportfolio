<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', project('site_name', 'Portfolio'))</title>
    <x-layout.assets-head />
    @stack('head')
</head>
<body class="d-flex flex-column min-vh-100">
    <x-navigation.public-nav />

    <main class="flex-grow-1 py-4">
        <div class="container">
            <x-layout.flash />
            @yield('content')
        </div>
    </main>

    <x-layout.public-footer />

    <x-layout.assets-scripts />
    @stack('scripts')
</body>
</html>

<script>
    (function () {
        const theme = localStorage.getItem('portfolio_theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.setAttribute('data-bs-theme', theme);
        if (theme === 'dark') document.documentElement.classList.add('dark');
    })();
</script>
<link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-icons/bootstrap-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/toast/toastify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}?v={{ filemtime(public_path('assets/css/app.css')) }}">

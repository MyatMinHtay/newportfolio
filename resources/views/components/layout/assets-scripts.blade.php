<script src="{{ asset('assets/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/toast/toastify.min.js') }}"></script>
<script>
    window.portfolioToast = {
        success: @json(session('toast_success')),
        error: @json(session('toast_error')),
        warning: @json(session('toast_warning')),
        info: @json(session('toast_info')),
        duration: {{ (int) project('toast_default_duration', 3000) }}
    };
</script>
<script src="{{ asset('assets/js/app.js') }}?v={{ filemtime(public_path('assets/js/app.js')) }}"></script>

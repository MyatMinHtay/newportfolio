@extends('layouts.auth')

@section('title', 'Admin Sign In')

@section('content')
    <div class="text-center mb-4">
        <h1 class="h4 fw-bold mb-1">{{ project('site_name', 'Portfolio') }}</h1>
        <p class="text-muted small">Sign in to manage your portfolio</p>
    </div>

    <x-card title="Sign In">
        @if (session('status'))
            <x-alert variant="success" class="mb-3">
                {{ session('status') }}
            </x-alert>
        @endif

        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <x-form.input
                name="email"
                label="Email address"
                type="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />

            <x-form.input
                name="password"
                label="Password"
                type="password"
                required
                autocomplete="current-password"
            />

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label small" for="remember">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="small text-decoration-none" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <div class="d-grid">
                <x-button variant="primary" type="submit">
                    Sign In
                </x-button>
            </div>
        </form>

        <x-slot:footer>
            <div class="text-center">
                <a href="{{ url('/') }}" class="small text-muted text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Back to Public Website
                </a>
            </div>
        </x-slot:footer>
    </x-card>
@endsection

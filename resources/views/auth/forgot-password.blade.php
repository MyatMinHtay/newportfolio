@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <div class="text-center mb-4">
        <h1 class="h4 fw-bold mb-1">{{ project('site_name', 'Portfolio') }}</h1>
        <p class="text-muted small">Reset your administrator password</p>
    </div>

    <x-card title="Forgot Password">
        <p class="text-muted small mb-3">
            Forgot your password? Enter your email address and we will email you a password reset link.
        </p>

        @if (session('status'))
            <x-alert variant="success" class="mb-3">
                {{ session('status') }}
            </x-alert>
        @endif

        <form method="POST" action="{{ route('password.email') }}" novalidate>
            @csrf

            <x-form.input
                name="email"
                label="Email address"
                type="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="email"
            />

            <div class="d-grid mb-3">
                <x-button variant="primary" type="submit">
                    Email Password Reset Link
                </x-button>
            </div>
        </form>

        <x-slot:footer>
            <div class="text-center">
                <a href="{{ route('login') }}" class="small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Return to Sign In
                </a>
            </div>
        </x-slot:footer>
    </x-card>
@endsection

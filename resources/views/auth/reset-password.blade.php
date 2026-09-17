@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="text-center mb-4">
        <h1 class="h4 fw-bold mb-1">{{ project('site_name', 'Portfolio') }}</h1>
        <p class="text-muted small">Choose a new password for your account</p>
    </div>

    <x-card title="Reset Password">
        <form method="POST" action="{{ route('password.store') }}" novalidate>
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <x-form.input
                name="email"
                label="Email address"
                type="email"
                :value="old('email', $request->email)"
                required
                autofocus
                autocomplete="username"
            />

            <x-form.input
                name="password"
                label="New Password"
                type="password"
                required
                autocomplete="new-password"
            />

            <x-form.input
                name="password_confirmation"
                label="Confirm Password"
                type="password"
                required
                autocomplete="new-password"
            />

            <div class="d-grid mb-3">
                <x-button variant="primary" type="submit">
                    Reset Password
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

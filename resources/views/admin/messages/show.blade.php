@extends('layouts.admin')

@section('title', 'Message from ' . $message->name)

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Messages', 'url' => route('admin.messages.index')],
        ['label' => $message->name],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Message Details"
        subtitle="Received on {{ $message->created_at->format('M d, Y \a\t h:i A') }}"
    >
        <x-slot:actions>
            <a href="mailto:{{ $message->email }}?subject={{ urlencode('Re: ' . ($message->subject ?: 'Inquiry')) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-reply-fill me-1"></i> Reply via Email
            </a>
            <form action="{{ route('admin.messages.toggle-read', $message) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi {{ $message->is_read ? 'bi-envelope' : 'bi-envelope-check' }} me-1"></i>
                    {{ $message->is_read ? 'Mark Unread' : 'Mark Read' }}
                </button>
            </form>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </x-slot:actions>
    </x-layout.page-header>

    <div class="row g-4">
        <div class="col-lg-8">
            <x-card class="shadow-sm">
                <div class="mb-4 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="text-truncate">
                            <h4 class="h5 fw-bold mb-1 text-break" style="color: var(--pf-text);">{{ $message->subject ?: '(No Subject)' }}</h4>
                            <div class="text-muted small text-break">
                                From: <strong class="text-body">{{ $message->name }}</strong>
                                &lt;<a href="mailto:{{ $message->email }}" class="text-decoration-none">{{ $message->email }}</a>&gt;
                            </div>
                        </div>
                        <span class="badge flex-shrink-0 {{ $message->is_read ? 'bg-secondary' : 'bg-primary' }}">
                            {{ $message->is_read ? 'Read' : 'New / Unread' }}
                        </span>
                    </div>
                </div>

                <div class="p-3 rounded-3 text-break" style="background-color: var(--pf-surface-muted); min-height: 200px; white-space: pre-wrap; font-size: 1rem; line-height: 1.6; color: var(--pf-text); word-break: break-word; overflow-wrap: anywhere;">{{ $message->message }}</div>

                <div class="mt-4 pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to messages
                    </a>
                    <a href="mailto:{{ $message->email }}?subject={{ urlencode('Re: ' . ($message->subject ?: 'Inquiry')) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-envelope me-1"></i> Compose Reply
                    </a>
                </div>
            </x-card>
        </div>

        <div class="col-lg-4">
            <x-card class="shadow-sm">
                <h5 class="card-title fw-bold mb-3">Sender Telemetry</h5>

                <dl class="mb-0 small">
                    <dt class="text-muted fw-normal">Full Name</dt>
                    <dd class="fw-semibold mb-3">{{ $message->name }}</dd>

                    <dt class="text-muted fw-normal">Email Address</dt>
                    <dd class="mb-3">
                        <a href="mailto:{{ $message->email }}" class="text-break">{{ $message->email }}</a>
                    </dd>

                    <dt class="text-muted fw-normal">Date &amp; Time</dt>
                    <dd class="mb-3">{{ $message->created_at->format('Y-m-d H:i:s') }} ({{ $message->created_at->diffForHumans() }})</dd>

                    <dt class="text-muted fw-normal">IP Address</dt>
                    <dd class="mb-0 font-monospace text-muted">{{ $message->ip_address ?: 'Unknown / Not recorded' }}</dd>
                </dl>
            </x-card>
        </div>
    </div>
@endsection

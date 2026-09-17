@props([
    'type' => 'info',
    'message' => null,
    'dismissible' => false,
])

@php
    $map = [
        'success' => 'alert-success',
        'danger' => 'alert-danger',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
    ];
    $class = $map[$type] ?? 'alert-info';
@endphp

{{-- Inline page message only. Global notifications use Toastify (ADR-016). --}}
<div {{ $attributes->class(['alert', $class, 'alert-dismissible fade show' => $dismissible]) }} role="alert">
    {{ $message ?? $slot }}
    @if ($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>

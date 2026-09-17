{{--
  Inline flash area for contextual page messages (Bootstrap Alert).
  Global success/error notifications use Toastify (ADR-016) — wired in a later phase.
--}}
@if (session('inline_status') || session('inline_message'))
    <x-alert
        :type="session('inline_status', 'info')"
        :message="session('inline_message')"
        :dismissible="true"
        class="mb-3"
    />
@endif

@php
    $errorBag = $errors ?? new \Illuminate\Support\ViewErrorBag;
@endphp

@if ($errorBag->any())
    <x-alert type="danger" :dismissible="true" class="mb-3">
        <div class="fw-semibold mb-1">Please fix the following:</div>
        <ul class="mb-0 ps-3">
            @foreach ($errorBag->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif

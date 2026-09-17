@props([
    'name',
    'label' => null,
    'value' => null,
    'rows' => 4,
    'required' => false,
    'help' => null,
])

@php
    $id = $attributes->get('id', $name);
    $errorBag = $errors ?? new \Illuminate\Support\ViewErrorBag;
    $hasError = $errorBag->has($name);
@endphp

<div {{ $attributes->class(['mb-3'])->except(['id']) }}>
    @if ($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($required)<span class="text-danger" aria-hidden="true">*</span>@endif
        </label>
    @endif

    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        @if ($required) required @endif
        @class(['form-control', 'is-invalid' => $hasError])
        {{ $attributes->except(['class', 'id']) }}
    >{{ old($name, $value) }}</textarea>

    @if ($help && ! $hasError)
        <div class="form-text">{{ $help }}</div>
    @endif

    @if ($hasError)
        <div class="invalid-feedback d-block">{{ $errorBag->first($name) }}</div>
    @endif
</div>

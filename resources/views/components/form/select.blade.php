@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'required' => false,
    'help' => null,
    'placeholder' => null,
])

@php
    $id = $attributes->get('id', $name);
    $errorBag = $errors ?? new \Illuminate\Support\ViewErrorBag;
    $hasError = $errorBag->has($name);
    $current = old($name, $selected);
@endphp

<div {{ $attributes->class(['mb-3'])->except(['id']) }}>
    @if ($label)
        <label for="{{ $id }}" class="form-label">
            {{ $label }}
            @if ($required)<span class="text-danger" aria-hidden="true">*</span>@endif
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $id }}"
        @if ($required) required @endif
        @class(['form-select', 'is-invalid' => $hasError])
        {{ $attributes->except(['class', 'id']) }}
    >
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $value => $optionLabel)
            <option value="{{ $value }}" @selected((string) $current === (string) $value)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @if ($help && ! $hasError)
        <div class="form-text">{{ $help }}</div>
    @endif

    @if ($hasError)
        <div class="invalid-feedback d-block">{{ $errorBag->first($name) }}</div>
    @endif
</div>

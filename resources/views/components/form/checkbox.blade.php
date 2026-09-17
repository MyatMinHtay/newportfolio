@props([
    'name',
    'label' => null,
    'checked' => false,
    'value' => '1',
])

@php
    $id = $attributes->get('id', $name);
    $isChecked = (bool) old($name, $checked);
@endphp

<div {{ $attributes->class(['form-check', 'mb-3'])->except(['id']) }}>
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        @checked($isChecked)
        class="form-check-input"
        {{ $attributes->except(['class', 'id']) }}
    >
    @if ($label)
        <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
    @endif
</div>

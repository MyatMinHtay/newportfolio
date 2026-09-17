@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null,
    'size' => null,
])

@php
    $classes = collect([
        'btn',
        'btn-'.$variant,
        $size ? 'btn-'.$size : null,
    ])->filter()->implode(' ');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class([$classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class([$classes]) }}>
        {{ $slot }}
    </button>
@endif

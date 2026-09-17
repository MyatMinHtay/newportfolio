@props([
    'variant' => 'secondary',
    'label' => null,
])

<span {{ $attributes->class(['badge', 'text-bg-'.$variant]) }}>
    {{ $label ?? $slot }}
</span>

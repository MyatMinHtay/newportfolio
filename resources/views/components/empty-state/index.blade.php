@props([
    'title' => 'Nothing here yet',
    'description' => null,
    'icon' => 'bi-inbox',
    'actionLabel' => null,
    'actionUrl' => null,
])

<div {{ $attributes->class(['text-center', 'py-5', 'px-3']) }}>
    <div class="mb-3 text-muted">
        <i class="bi {{ $icon }}" style="font-size: 2.5rem;" aria-hidden="true"></i>
    </div>
    <h2 class="h5 mb-2">{{ $title }}</h2>
    @if ($description)
        <p class="text-muted mb-3">{{ $description }}</p>
    @endif
    @if ($actionLabel && $actionUrl)
        <x-button variant="primary" :href="$actionUrl">{{ $actionLabel }}</x-button>
    @endif
    {{ $slot }}
</div>

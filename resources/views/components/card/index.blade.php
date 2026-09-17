@props([
    'title' => null,
])

<div {{ $attributes->class(['card', 'border-0', 'pf-surface']) }}>
    @if ($title || isset($header))
        <div class="card-header bg-transparent">
            @isset($header)
                {{ $header }}
            @else
                <h3 class="h6 mb-0">{{ $title }}</h3>
            @endif
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="card-footer bg-transparent">
            {{ $footer }}
        </div>
    @endisset
</div>

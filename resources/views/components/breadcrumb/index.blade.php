@props([
    'items' => [],
])

@if (count($items))
    <nav {{ $attributes->class(['mb-3']) }} aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            @foreach ($items as $item)
                @php
                    $label = is_array($item) ? ($item['label'] ?? '') : (string) $item;
                    $url = is_array($item) ? ($item['url'] ?? null) : null;
                    $isLast = $loop->last;
                @endphp
                <li class="breadcrumb-item {{ $isLast ? 'active' : '' }}" @if ($isLast) aria-current="page" @endif>
                    @if (! $isLast && $url)
                        <a href="{{ $url }}">{{ $label }}</a>
                    @else
                        {{ $label }}
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif

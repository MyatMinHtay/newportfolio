@props([
    'paginator' => null,
])

@if ($paginator)
    <div {{ $attributes->class(['d-flex', 'justify-content-center', 'mt-4']) }}>
        {{ $paginator->links() }}
    </div>
@elseif ($slot->isNotEmpty())
    <div {{ $attributes->class(['d-flex', 'justify-content-center', 'mt-4']) }}>
        {{ $slot }}
    </div>
@endif

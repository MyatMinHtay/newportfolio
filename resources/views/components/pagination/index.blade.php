@props([
    'paginator' => null,
])

@if ($paginator)
    <div {{ $attributes->class(['d-flex', 'justify-content-center', 'mt-4', 'overflow-auto', 'w-100']) }}>
        {{ $paginator->links() }}
    </div>
@elseif ($slot->isNotEmpty())
    <div {{ $attributes->class(['d-flex', 'justify-content-center', 'mt-4', 'overflow-auto', 'w-100']) }}>
        {{ $slot }}
    </div>
@endif

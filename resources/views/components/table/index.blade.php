@props([
    'hover' => true,
    'striped' => false,
])

<div {{ $attributes->class(['table-responsive']) }}>
    <table @class([
        'table',
        'align-middle',
        'mb-0',
        'table-hover' => $hover,
        'table-striped' => $striped,
    ])>
        {{ $slot }}
    </table>
</div>

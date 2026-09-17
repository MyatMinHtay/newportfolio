@props([
    'id',
    'title' => 'Confirm',
    'size' => null,
])

@php
    $dialogClass = collect(['modal-dialog', $size ? 'modal-'.$size : null])->filter()->implode(' ');
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}-label" aria-hidden="true" {{ $attributes }}>
    <div class="{{ $dialogClass }}">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="{{ $id }}-label">{{ $title }}</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>

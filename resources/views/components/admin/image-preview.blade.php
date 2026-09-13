@props(['src' => null])

@if ($src)
    <img
        src="{{ asset($src) }}"
        {{ $attributes->class('img-fluid') }}
        style="{{ $attributes->get('style') ?: 'object-fit: cover; max-height: 100px;' }}"
    >
@endif
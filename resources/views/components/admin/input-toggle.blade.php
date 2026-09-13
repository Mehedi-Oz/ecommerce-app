@props([
    'label' => null,
    'name' => null,
    'checked' => false,
])

<div class="mb-3">
    <div class="custom-control custom-switch">
        <input type="hidden" name="{{ $name }}" value="0">

        <input
            type="checkbox"
            name="{{ $name }}"
            id="{{ $attributes->get('id') ?? $name }}"
            value="1"
            {{ $attributes->class('custom-control-input') }}
            @checked($checked)
        >

        @if ($label)
            <label class="custom-control-label" for="{{ $attributes->get('id') ?? $name }}">{{ $label }}</label>
        @endif
    </div>

    <x-admin.input-error :for="$name" />
</div>
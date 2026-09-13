@props([
    'type' => 'text',
    'label' => null,
    'id' => null,
    'name' => null,
    'placeholder' => null,
    'value' => null,
    'hint' => null,
])

<div class="mb-3">
    @if ($label)
        <label class="form-label" for="{{ $id ?: $name }}">{{ $label }}</label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $id ?: $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
    >

    @if ($hint)
        <small class="form-text text-muted">{{ $hint }}</small>
    @endif

    <x-admin.input-error :for="$name" />
</div>
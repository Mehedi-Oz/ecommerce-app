@props([
    'label' => null,
    'id' => null,
    'name' => null,
    'placeholder' => null,
    'value' => null,
    'rows' => 5,
])

<div class="mb-3">
    @if ($label)
        <label class="form-label" for="{{ $id ?: $name }}">{{ $label }}</label>
    @endif

    <textarea
        rows="{{ $rows }}"
        name="{{ $name }}"
        id="{{ $id ?: $name }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
    >{{ old($name, $value) }}</textarea>

    <x-admin.input-error :for="$name" />
</div>
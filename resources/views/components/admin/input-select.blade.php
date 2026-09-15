@props([
    'label' => null,
    'name' => null,
    'selected' => null,
])

<div class="mb-3">
    @if ($label)
        <label class="form-label" for="{{ $name }}">{{ $label }}</label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->class(['form-select', 'is-invalid' => $errors->has($name)]) }}
    >
        <option value="" disabled @selected(! $selected)>{{ __('Select') }}</option>
        {{ $slot }}
    </select>

    <x-admin.input-error :for="$name" />
</div>
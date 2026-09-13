@props(['label' => null])

<button type="submit" {{ $attributes->merge(['class' => 'btn btn-success waves-effect waves-light text-white']) }}>
    {{ $label }}
</button>
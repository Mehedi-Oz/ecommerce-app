@props(['for'])

@error($for)
    <small {{ $attributes->merge(['class' => 'text-danger d-block mt-1']) }}>{{ $message }}</small>
@enderror
@props(['label', 'value'])
<div>
    <label>
        <input type="radio" {{ $attributes->merge(['class' => 'form-radio mr-1']) }} value="{{ $value }}"/> {!! $label ?? $value  !!}
    </label>
</div>
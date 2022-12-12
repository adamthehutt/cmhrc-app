@props(['options' => [], 'empty' => false])
@php ($options = \Illuminate\Support\Arr::isList((array) $options) ? array_combine((array) $options, (array) $options) : $options)
<div>
    <select {{ $attributes->merge(['class' => "form-select border-gray-300"]) }}>
        @if ($empty)
            <option>{{ $empty !== true ? $empty : '' }}</option>
        @endif
        @foreach ($options as $key => $value)
            <option value="{{$key}}">{{ $value }}</option>
        @endforeach
        {{ $slot }}
    </select>
    @error($attributes->wire('model')->value())
        <x-input-error :messages="[$message]" />
    @enderror
</div>
@props(['options' => [], 'empty' => false])
<div>
    <select {{ $attributes->merge(['class' => "form-select border-gray-300"]) }}>
        {{ $slot }}
        @if ($empty)
            <option></option>
        @endif
        @foreach ($options as $key => $value)
            <option value="{{$key}}">{{ $value }}</option>
        @endforeach
    </select>
    @error($attributes->wire('model')->value())
        <x-input-error :messages="[$message]" />
    @enderror
</div>